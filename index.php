<?php
  require_once "bootstrap.php";

  use Dorkodu\SuperPage\SuperPage;

  session_start();

  # ROUTES

  $superpage = new SuperPage();

  # frontpage and aliases
  $superpage->get("/", $FrontpageController);
  $superpage->get("/index.php", $FrontpageController);
  $superpage->get("/index.html", $FrontpageController);
  $superpage->get("/index", $FrontpageController);
  $superpage->get("/frontpage", $FrontpageController);
  
  # other pages
  $superpage->get("/terms", $TermsPageController);
  $superpage->get("/about", $AboutPageController);

  $superpage->get("/register", $RegisterPageController);
  $superpage->get("/login", $LoginPageController);
  $superpage->get("/logout", $LogoutPageController);

  $superpage->get("/user/{id}", $ProfilePageController);

  # not found
  $superpage->get("/oops", $ErrorPageController);
  $superpage->fallback($ErrorPageController);

  # run it!
  $superpage->run();
