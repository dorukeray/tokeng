<?php
  require_once "bootstrap.php";

  use Tokeng\Route;
  use Tokeng\TokengPage;

  $frontpage = function($payload) {

  };

  Route::to("/", "get", $frontpage);