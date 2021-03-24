<?php
  require_once "loot/loom-weaver.php";

  function stringEndsWith(string $haystack, string $needle)
  {
    return strrpos($haystack, $needle) === (strlen($haystack) - strlen($needle));
  }