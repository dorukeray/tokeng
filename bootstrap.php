<?php
  require_once "loot/loom-weaver.php";
  require_once "pages.php";

  use Tokeng\TokengPage;

  function stringEndsWith(string $haystack, string $needle)
  {
    return strrpos($haystack, $needle) === (strlen($haystack) - strlen($needle));
  }

  /* PAGE Controllers */

  $FrontpageController = function ($payload) {
    
    $challange = "some hash";

    $frontpage = new TokengPage(
      "Welcome to Tokeng! - Tokeng",
      "Welcome to Tokeng!",
      `<div class="set frontpage">
      <h2>Tokeng: Match'n Learn</h2>
      <p>Tokeng is a social utility that matches you with the people to help you learn English.</p>
      <p>You can use Tokeng to :</p>
      <ul class="list">
        <li><p>Create a profile page</p></li>
        <li><p>Randomly match with people with the same level of you</p></li>
        <li><p>Find people to pair with on learning English</p></li>
      </ul>
    </div>
    <div class="set login-box">
      <h2>Login</h2>
      <form action="/login" method="post">
        
        <input type="hidden" id="challange" name="challange" value="`.$challange.`">

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" autocomplete="off">

        <label for="pass">Password :</label>
        <input type="password" name="pass" id="pass">
        
        <button type="submit" name="login-button" id="login-button">Login</button>
      
      </form>
    </div>`,
      false
    );
  };