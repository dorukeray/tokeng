<?php
  namespace Dorkodu\Seekr;

  use Dorkodu\Seekr\Timer;
  
  class PerformanceProfiler
  {
    private int $timePrecision;
    private int $memoryPrecision;
    private $timer;

    public function __construct(int $timePrecision = 2, int $memoryPrecision = 2)
    {
      $this->timePrecision = $timePrecision;
      $this->memoryPrecision = $memoryPrecision;
      $this->timer = new Timer(true);
    }

    public function start()
    {
      $this->timer->start();
    }

    public function stop()
    {
      $this->timer->stop();
    }

    public function reset()
    {
      $this->timer->reset();
    }

    public function passedTime()
    {
      return round($this->timer->passedTime(), $this->timePrecision);
    }

    public function memoryPeakUsage()
    {
      return self::formatBytes(memory_get_peak_usage(), $this->memoryPrecision);
    }

    public function memoryUsage()
    {
      return self::formatBytes(memory_get_usage(), $this->memoryPrecision);
    }

    private static function formatBytes($bytes, $precision = 1)
    {
      $units = array("B", "kB", "MB", "GB", "TB");

      $bytes = max($bytes, 0);
      $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
      $pow = min($pow, count($units) - 1);
      $bytes /= (1 << (10 * $pow));

      return round($bytes, $precision) . " " . $units[$pow];
    }
  }
  
  