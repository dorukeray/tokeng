<?php
  require_once "bootstrap.php";

  use Tokeng\Route;
  use Tokeng\TokengPage;

  # routes

  # frontpage and aliases
  Route::to("/", "get", $FrontpageController);
  Route::to("/index.php", "get", $FrontpageController);
  Route::to("/index", "get", $FrontpageController);
  Route::to("/frontpage", "get", $FrontpageController);
  
  # std pages
  Route::to("/oops", "get", $ErrorPageController);
  Route::to("/terms", "get", $ErrorPageController);
  Route::to("/about", "get", $AboutPageController);

  Route::to("/register", "get", $RegisterPageController);
  Route::to("/login", "post", $LoginPageController);
  Route::to("/logout", "post", $LogoutPageController);