<?php
  namespace Dorkodu\Seekr;

  use \Exception;
  use Dorkodu\Seekr\Contradiction;

  /**
   * A Premise class for proposing an assertment with a statement that can be resolved into a boolean value of true|false
   */
  class Premise
  {
    /**
     * Asserts a premise. When the statement is not true, throws a Contradiction with given message and code
     *
     * @param boolean $statement
     * @param string $contradictionMessage A descriptive message about that
     * @param string $code Like a unique identifier of that contradiction in your code
     * @return void
     */
    public static function propose(bool $statement, string $contradictionMessage = "", string $code = null)
    {
      # is statement boolean ? if so, evaluete it
      # if false, throw a Contradiction, using the contradictionMessage
  
      switch ($statement) {
        case false:
          throw new Contradiction($contradictionMessage, $code);
          break;
        case true:
          return true;
          break;
        default:
          throw new Contradiction("Cannot evaluate the statement from premise", "PREMISE::CANNOT_EVALUATE");
          break;
      }
    }
  }