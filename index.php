<?php
  require_once "bootstrap.php";

  use Dorkodu\SuperPage\SuperPage;

  # ROUTES

  $superpage = new SuperPage();

  # frontpage and aliases
  $superpage->to("/", "GET", $FrontpageController);
  $superpage->to("/index.php", "GET", $FrontpageController);
  $superpage->to("/index", "GET", $FrontpageController);
  $superpage->to("/frontpage", "GET", $FrontpageController);
  
  # other pages
  $superpage->to("/terms", "GET", $ErrorPageController);
  $superpage->to("/about", "GET", $AboutPageController);

  $superpage->to("/register", "GET", $RegisterPageController);
  $superpage->to("/login", "POST", $LoginPageController);
  $superpage->to("/logout", "POST", $LogoutPageController);

  $superpage->to("/user/{id}", "GET", $ProfilePageController);

  # not found
  $superpage->to("/oops", "GET", $ErrorPageController);
  $superpage->fallback($ErrorPageController);

  # run it!
  $superpage->run();