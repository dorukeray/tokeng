<?php
  /**
   * @author      Doruk Eray <doruk@dorkodu.com>
   * @copyright   Copyright (c), 2021 Doruk Eray
   * @license     MIT public license
   */
  namespace Dorkodu\SuperPage;

  use Dorkodu\SuperPage\Route;

  /**
   * A simple, callback based router.
   */
  class SuperPage
  {
    private $routes = array();
    private $context = array();

    public $root;


    private $fallbackCallback;

    /**
     * Create a SuperPage router with optional context
     */
    public function __construct($context = array())
    {
      $this->context = $context;
    }

    /**
     * If the URL pattern & method both matches, then run the callback.
     *
     * @param string $URLPattern
     * @param string $method
     * @param Callable $callback
     *
     * @return void
     */
    public function to(string $path, string $method, Callable $callback)
    {
      # create a new route
      $route = new Route($path, $method, $callback);
      array_push($this->routes, $route);
    }

    /**
     * Store a route and a handling function to be executed when accessed using one of the specified methods.
     *
     * @param string          $methods Allowed methods, | delimited
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $fn      The handling function to be executed
     */
    public function match($methods, $pattern, $fn)
    {
      $pattern = $this->baseRoute . '/' . trim($pattern, '/');
      $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

      foreach (explode('|', $methods) as $method) {
        $this->afterRoutes[$method][] = array(
            'pattern' => $pattern,
            'fn' => $fn,
        );
      }
    }

    /**
     * Execute the router.
     * Loop all defined routes, and execute the callback function if a match was found.
     *
     * @return bool
     */
    public function run()
    {
      # Define which method we need to handle
      $this->requestMethod = $this->getRequestMethod();

      # Handle all routes
      $numHandled = 0;
      if (isset($this->afterRoutes[$this->requestedMethod])) {
        $numHandled = $this->handle($this->afterRoutes[$this->requestedMethod], true);
      }

      # If no route was handled, trigger the 404 (if any)
      if ($numHandled === 0) {
        $this->notFound();
      } 
      
      # If a route was handled, perform the finish callback (if any)
      else {
        if ($callback && is_callable($callback)) {
            $callback();
        }
      }

      // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
      if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
        ob_end_clean();
      }

      // Return true if a route was handled, false otherwise
      return $numHandled !== 0;
    }

        /**
     * Handle a a set of routes: if a match is found, execute the relating handling function.
     *
     * @param array $routes       Collection of route patterns and their handling functions
     * @param bool  $quitAfterRun Does the handle function need to quit after one route was matched?
     *
     * @return int The number of routes handled
     */
    private function handle($routes, $quitAfterRun = false)
    {
        // Counter to keep track of the number of routes we've handled
        $numHandled = 0;

        // The current page URL
        $uri = $this->getCurrentUri();

        // Loop all routes
        foreach ($routes as $route) {
            // Replace all curly braces matches {} into word patterns (like Laravel)
            $route['pattern'] = preg_replace('/\/{(.*?)}/', '/(.*?)', $route['pattern']);

            // we have a match!
            if (preg_match_all('#^' . $route['pattern'] . '$#', $uri, $matches, PREG_OFFSET_CAPTURE)) {
                // Rework matches to only contain the matches, not the orig string
                $matches = array_slice($matches, 1);

                // Extract the matched URL parameters (and only the parameters)
                $params = array_map(function ($match, $index) use ($matches) {

                    // We have a following parameter: take the substring from the current param position until the next one's position (thank you PREG_OFFSET_CAPTURE)
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        if ($matches[$index + 1][0][1] > -1) {
                            return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                        }
                    } // We have no following parameters: return the whole lot

                    return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                // Call the handling function with the URL parameters if the desired input is callable
                $this->invoke($route['fn'], $params);

                ++$numHandled;

                // If we need to quit, then quit
                if ($quitAfterRun) {
                    break;
                }
            }
        }

        // Return the number of routes handled
        return $numHandled;
    }

    /**
     * Set a 404 fallback route to redirect in case others doesn't match
     *
     * @param Callable $callback
     * @return void
     */
    public function fallback(callable $callback)
    {
      $this->fallbackController = $callback;
    }

    /**
     * Triggers 404 response
     */
    public function notFound()
    {
      if ($this->fallbackCallback) {
        $this->invoke($this->notFoundCallback);
      } else {
        header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
      }
    }

    private function invoke($fn, $params = array())
    {
      if (is_callable($fn)) {
        call_user_func_array($fn, $params);
      }
    }

    private static function matchMethod(string $method)
    {
      $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
      $method = strtolower($method);
      return $requestMethod === $method;
    }

    private static function pathToPattern(string $url)
    {
      $url = self::removePathSlash($url);
      # return the pattern
      return "~^" . $url . "$~";
    }

    private static function matchPath(string $url)
    {
      $path = self::getPath();
      $pattern = self::pathToPattern($url);

      $matches = [];
      $result = preg_match($pattern, $path, $matches);

      if ($result === 1) {
        return $matches;
      } else return false;
    }

    /**
     * Removes the ending slash '/' from the path, if it has.
     *
     * @param string $path
     *
     * @return string
     */
    private static function removePathSlash(string $path)
    {
      if ($path !== '/' && stringEndsWith($path, '/')) {
        $path = rtrim($path, '/');
      }

      return $path;
    }

    private static function getPath()
    {
      return $path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    }

    /**
     * Define the current relative URI.
     *
     * @return string
     */
    public function getURI()
    {
      # Get the current Request URI and remove rewrite base path from it (= allows one to run the router in a sub folder)
      $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen($this->getBasePath()));
      # Don't take query params into account on the URL
      if (strstr($uri, '?')) {
        $uri = substr($uri, 0, strpos($uri, '?'));
      }
      # Remove trailing slash + enforce a slash at the start
      return '/' . trim($uri, '/');
    }

    /**
     * Get all request headers.
     *
     * @return array The request headers
     */
    public function getRequestHeaders()
    {
      $headers = array();

      # Method getallheaders() not available or went wrong: manually extract 'm
      foreach ($_SERVER as $name => $value) {
        if ((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')) {
          $headers[str_replace(array(' ', 'Http'), array('-', 'HTTP'), ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
        }
      }

      return $headers;
    }

    /**
     * Get the request method used, taking overrides into account.
     *
     * @return string The Request method to handle
     */
    public function getRequestMethod()
    {
      # Take the method as found in $_SERVER
      $method = $_SERVER['REQUEST_METHOD'];

      # If it's a HEAD request override it to being GET and prevent any output, as per HTTP Specification
      # @url http://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html#sec9.4
      if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
        ob_start();
        $method = 'GET';
      }

      # If it's a POST request, check for a method override header
      elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $headers = $this->getRequestHeaders();
        if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], array('PUT', 'DELETE', 'PATCH'))) {
            $method = $headers['X-HTTP-Method-Override'];
        }
      }

      return $method;
    }

    /**
     * Return server base Path, and define it if isn't defined.
     *
     * @return string
     */
    public function getBasePath()
    {
      # Check if server base path is defined, if not define it.
      if ($this->serverBasePath === null) {
        $this->serverBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
      }

      return $this->serverBasePath;
    }

    /**
     * Explicilty sets the server base path. 
     * To be used when your entry script path differs from your entry URLs.
     *
     * @param string
     */
    public function setBasePath($serverBasePath)
    {
        $this->serverBasePath = $serverBasePath;
    }
  }
