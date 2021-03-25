<?php
  error_reporting(E_ERROR);
	setlocale(LC_TIME, 'tr_TR');

  # first load the namespaces, then the actual code.
  require_once "loot/loom-weaver.php";

  # load page controllers
  require_once "pages.php";