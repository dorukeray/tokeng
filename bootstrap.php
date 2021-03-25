<?php
  error_reporting(E_ALL);
	setlocale(LC_TIME, 'tr_TR');

  require_once "loot/loom-weaver.php";
  # first load the namespaces, then the actual code.
  require_once "pages.php";

  use Tokeng\TokengPage;

  function stringEndsWith(string $haystack, string $needle)
  {
    return strrpos($haystack, $needle) === (strlen($haystack) - strlen($needle));
  }
