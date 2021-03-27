<?php
  namespace Dorkodu\Seekr;
  
  /**
   * Contradiction is a negative result of Say::premise, simply tells you why your premise makes a contradiction occur
   */
  class Contradiction extends \Exception
  {
    /**
     * Class constructor.
     */
    public function __construct(string $message = "", string $code = null)
    {
      $this->message = $message;
      $this->code = $code;
    }

    public function toString()
    {
      $stringified = "";

      if (!is_null($this->code) && !empty($this->message)) {
        $stringified = sprintf("Contradiction [ %s ] : %s",
                        $this->code,
                        $this->message
                      );
      } else if (is_null($this->code) && !empty($this->message)) {
        $stringified = sprintf("Contradiction : %s", $this->message );
      } else if (is_null($this->code) && empty($this->message)) {
        $stringified = "An unknown contradiction occured.";
      }

      return $stringified;
    }
  }