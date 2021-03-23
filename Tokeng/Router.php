<?php 
  namespace Tokeng;
  
  /**
   * A simple, callback based router.
   */
  class Router
  {
    /**
     * If the URL pattern & method both matches, then run the callback. 
     *
     * @param string $URLPattern
     * @param string $method
     * @param Callable $callback
     * @return void
     */
    public static function to(string $URLPattern, string $method, Callable $callback)
    {
      
    }

    private function matchURL(string $pattern)
    {
      
    }

    private function matchMethod(string $match)
    {
      # code...
    }
  }
  