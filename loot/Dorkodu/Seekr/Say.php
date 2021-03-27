<?php
  namespace Dorkodu\Seekr;

  use Exception;
  use Dorkodu\Seekr\Contradiction;

  /**
   * Say class provides useful assertions for Seekr tests
   */
  class Say
  {
    /**
     * RULE :
     * - Write a statement that can be resolved into a boolean value
     * - Then propose it via Say::premise(statement, ...)
     * - IF something goes wrong, it will throw a Contradiction
     * - ELSE everything goes fine, nothing special happens and this means the premise is true
     */

    /**
     * Check if this thing equals to your expectation.
     */
    public static function equal($expectation, $parameterToTest)
    {
      $statement = ($expectation === $parameterToTest);
      Premise::propose($statement, "Not Equal", "SAY::EQUAL");
    }

    public static function count(int $expectedCount, $haystack)
    {
      $statement = (count($haystack) === $expectedCount);
      Premise::propose($statement, "Count Does Not Match", "SAY::COUNT");
    }

    public static function contains(string $needle, string $haystack)
    {
      $statement = (strpos($haystack, $needle) !== false);
      Premise::propose($statement, "Does Not Contains", "SAY::CONTAINS");
    }

    public static function null($proposedValue)
    {
      $statement = is_null($proposedValue);
      Premise::propose($statement, "Not Null", "SAY::NULL");
    }

    public static function notNull($proposedValue)
    {
      $statement = !is_null($proposedValue);
      Premise::propose($statement, "Is Null", "SAY::NOT_NULL");
    }

    public static function empty($thing)
    {
      $statement = empty($thing);
      Premise::propose($statement, "Not Empty", "SAY::EMPTY");
    }

    public static function notEmpty($thing)
    {
      $statement = !empty($thing);
      Premise::propose($statement, "Is Empty", "SAY::NOT_EMPTY");
    }

    public function arrayHasKey($key, array $haystack)
    {
      $statement = array_key_exists($key, $haystack);
      Premise::propose($statement, "Is Empty", "SAY::NOT_EMPTY");
    }

    /*

    public function sayObjectEquals($objectToCompare, $objectYouHave)
    {
      
    }
    
    public function sayObjectStrictEquals($objectToCompare, $objectYouHave)
    {
      
    }

    public function sayArrayEquals(array $arrayToCompare, array $arrayYouHave)
    {
      if (count($arrayToCompare) === count($arrayYouHave) && array_diff($arrayToCompare, $arrayYouHave) === array_diff($arrayYouHave, $arrayToCompare)) {
        # code...
      }
    }

    public static function sayArrayStrictEquals($arrayToCompare, $objectYouHave)
    {
      
    }

    public static function directoryExists(string $path)
    {
      return is_dir($path);
    }

    public static function fileExists($path)
    {
      return is_file($path);
    }
    */
  }
