<?php
  namespace Dorkodu\Seekr;
  
  /**
   * Timer - a basic utility to use a stopwatch in PHP.
   */
  class Timer
  {
    protected $beginTimestamp;
    protected $endTimestamp;
    protected $usingMicroseconds;

    public function __construct($useMicroseconds = false)
    {
      $this->usingMicroseconds = $useMicroseconds;
    }

    public function start()
    {
      if ($this->usingMicroseconds === true) {
        $this->beginTimestamp = microtime(true);
      } else {
        $this->beginTimestamp = time();
      }
    }

    public function stop()
    {
      if ($this->usingMicroseconds === true) {
        $this->endTimestamp = microtime(true);
      } else {
        $this->endTimestamp = time();
      }
    }

    public function reset()
    {
      $this->beginTimestamp = 0;
      $this->endTimestamp = 0;
    }

    public function isStopped()
    {
      return (!empty($this->beginTimestamp) && is_numeric($this->beginTimestamp) && !empty($this->endTimestamp) && is_numeric($this->endTimestamp));
    }

    public function isRunning()
    {
      return (!empty($this->beginTimestamp) && is_numeric($this->beginTimestamp));
    }

    public function passedTime()
    {
      if ($this->isStopped()) {
        return $this->endTimestamp - $this->beginTimestamp;
      } elseif ($this->isRunning()) {
        if ($this->usingMicroseconds === true) {
          return microtime(true) - $this->beginTimestamp;
        } else {
          return time() - $this->beginTimestamp;
        }
      } else {
        return 0;
      }
    }
  }