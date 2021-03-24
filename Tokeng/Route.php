<?php
  namespace Tokeng;
  
  /**
   * A simple, callback based router.
   */
  class Route
  {
    /**
     * If the URL pattern & method both matches, then run the callback. 
     *
     * @param string $URLPattern
     * @param string $method
     * @param Callable $callback
     * 
     * @return void
     */
    public static function to(string $path, string $method, Callable $callback)
    {
      $result = self::matchPath($path);

      if($result != false && self::matchMethod($method)) {
        call_user_func_array($callback, [$result]);
      }
    }

    private static function matchMethod(string $method)
    {
      $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
      $method = strtolower($method);
      return $requestMethod === $method;
    }

    private static function urlToPattern(string $url)
    {
      $url = self::removePathSlash($url);
      # return the pattern
      return "~^" . $url . "$~";
    }
  
    private static function matchPath(string $url)
    {
      $path = self::getPath();
      $pattern = self::urlToPattern($url);
  
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
  