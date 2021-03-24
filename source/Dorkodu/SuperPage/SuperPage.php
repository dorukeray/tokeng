<?php
  namespace Dorkodu\SuperPage;

  use Dorkodu\SuperPage\Route;

  /**
   * A simple, callback based router.
   */
  class SuperPage
  {
    private array $routes = [];
    private array $context = [];

    private Route $fallbackRoute;

    /**
     * Create a SuperPage router with 
     */
    public function __construct(array $context = [])
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

    public function run()
    {
      /**
       * - loop all routes
       * - if matches, stop and route to
       * - if not, matches everything else
       */

     /* $result = self::matchPath($path);

      if($result != false && self::matchMethod($method)) {
        call_user_func_array($callback, [$result]);
      }

      */

    }

    /**
     * Set a 404 fallback route to redirect in case others doesn't match
     *
     * @param string $path
     * @param string $method
     * @param Callable $callback
     * @return void
     */
    public function fallback(string $path, callable $callback)
    {
      $this->fallbackRoute = new Route($path, 'get', $callback);
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
        $path = substr($path, 0, strlen($path) - 1);
      }

      return $path;
    }
  
    private static function getPath()
    {
      $path = parse_url($_SERVER['REQUEST_URI'])['path']; 
      return self::removePathSlash($path);
    }
  }
  