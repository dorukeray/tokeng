<?php 

  use Tokeng\TokengPage;

  # pages

  $FrontpageController = function ($payload) {
      
    $challange = "some hash";

    $frontpage = new TokengPage(
      "Welcome to Tokeng! - Tokeng",
      "Welcome to Tokeng!",
      '
      <div class="set frontpage">
      <h2>Tokeng: Match\'n Learn</h2>
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
        
        <input type="hidden" id="challange" name="challange" value="'. $challange .'">

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" autocomplete="off">

        <label for="pass">Password :</label>
        <input type="password" name="pass" id="pass">
        
        <button type="submit" name="login-button" id="login-button">Login</button>
      
      </form>
    </div>
    ',
      false
    );

    $frontpage->render();
  };

  $ErrorPageController = function ($payload) {
    $errorpage = new TokengPage(
      "Oops! - Tokeng",
      "Oops!", 
      '<div class="set">
        <h1>Oops!</h1>
        <p>Something went wrong.</p>
        <a href="/">Go back to home page</a>
       </div>
      <div class="clearfix"></div>', 
      false);
    $errorpage->render();
  };

  $AboutPageController = function ($payload) {
    $aboutPage = new TokengPage(
      "About - Tokeng",
      "About Tokeng", 
      <<<HTML
      <div class="set half-column">
        <h2 class="underlined-title">The Project</h2>
        <p>Tokeng is a social utility that matches you with the people to help you learn English. When did you last time wondered who knows how much English? We've got the answer!</p>
        <p>You can see the people who has the same level with you. Or you can randomly match with someone to study together!</p>
      </div>
      <div class="set half-column">
        <h2 class="underlined-title">The People</h2>
        <p>Doruk Eray <span style="font-weight: bold; color: var(--dorkodu-smokegray-dim); float: right;">The Creator, Software Engineer</label></p>
      </div>
      <div class="set half-column">
        <h2 class="underlined-title">The Purpose</h2>
        <p>Nothing. (to be honest...)</p>
        <p>Tokeng started as a school project. Our primary goal is to help you develop your English skills by creating an online directory of people and their English knowledge.</p>
        <p>But you can do a few more things here :</p>
        <ul class="list">
          <li><p>Create a profile page</p></li>
          <li><p>Randomly match with people who is equivalent to you in English skills.</p></li>
          <li><p>Find people to pair with on learning English</p></li>
        </ul>
      </div>
    HTML, 
      false);
    $aboutPage->render();
  };