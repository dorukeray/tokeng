<?php
  namespace Dorkodu\SuperPage;
  
  class Route
  {
    private string $path;
    private string $method;
    private $callback;

    /**
     * Create an entity for Route
     *
     * @param string $path
     * @param string $method
     * @param Callable $callback
     * 
     * @return void
     */
    public function __construct(string $path, string $method, Callable $callback)
    {
      $this->path = $this->pathToPattern($path);
      $this->method = $method;
      $this->callback = $callback;
    }

    public function getPath()
    {
      return $this->path;
    }

    public function getMethod()
    {
      return $this->method;
    }

    public function getCallback()
    {
      return $this->callback;
    }

    private function pathToPattern(string $url)
    {
      $url = $this->removePathSlash($url);
      # return the pattern
      return "~^" . $url . "$~";
    }
  
    /**
     * Removes the ending slash '/' from the path, if it has.
     *
     * @param string $path
     * 
     * @return string
     */
    private function removePathSlash(string $path)
    {
      if ($path !== '/' && stringEndsWith($path, '/')) {
        $path = substr($path, 0, strlen($path) - 1);
      }
      return $path;
    }
  }
  