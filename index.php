<?php
  require_once "bootstrap.php";

  use Dorkodu\SuperPage\SuperPage;
  use Tokeng\TokengPage;

  # routes

  $superpage = new SuperPage();

  # frontpage and aliases
  $superpage->to("/", "get", $FrontpageController);
  $superpage->to("/index.php", "get", $FrontpageController);
  $superpage->to("/index", "get", $FrontpageController);
  $superpage->to("/frontpage", "get", $FrontpageController);
  
  # std pages
  $superpage->to("/terms", "get", $ErrorPageController);
  $superpage->to("/about", "get", $AboutPageController);

  $superpage->to("/register", "get", $RegisterPageController);
  $superpage->to("/login", "post", $LoginPageController);
  $superpage->to("/logout", "post", $LogoutPageController);

  $superpage->to("/oops", "get", $ErrorPageController);

  $superpage->run();