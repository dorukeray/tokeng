<?php
  namespace Dorkodu\Seekr;

  /**
   * Provides a loggable entity with information on a test and how it executed
   **/
  class TestResult
  {
    protected $_testableInstance = null;
    protected $_isSuccess = false;
    protected $_output = '';
    protected $_test = null;
    protected $_exception = null;
    protected $_executionTime = null;
    protected $_peakMemoryUsage = null;

    public function isSuccess()
    {
      return $this->_isSuccess;
    }
    
    public function getOutput()
    {
      return $this->_output;
    }

    public function setOutput( string $value )
    {
      $this->_output = $value;
    }

    public function setExecutionTime( float $value )
    {
      $this->_executionTime = $value;
    }

    public function setPeakMemoryUsage( $value )
    {
      $this->_peakMemoryUsage = $value;
    }

    public function getPeakMemoryUsage()
    {
      return $this->_peakMemoryUsage;
    }

    public function getExecutionTime()
    {
      return $this->_executionTime;
    }
    
    public function getTest()
    {
      return $this->_test;
    }

    public function getName()
    {
      return $this->_test->getName();
    }

    public function getException()
    {
      return $this->_exception;
    }

    public static function createFailure( Seekr $object, \ReflectionMethod $test, \Exception $exception )
    {
      $result = new self();
      $result->_isSuccess = false;
      $result->_testableInstance = $object;
      $result->_test = $test;
      $result->_exception = $exception;

      return $result;
    }

    public static function createSuccess( Seekr $object, \ReflectionMethod $test )
    {
      $result = new self();
      $result->_isSuccess = true;
      $result->_testableInstance = $object;
      $result->_test = $test;

      return $result;
    }
}