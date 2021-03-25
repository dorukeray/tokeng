<?php
  namespace Tokeng;

  class TokengPage
  {
    private string $template = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/default.css">
  <link rel="shortcut icon" href="/assets/favicon.png">
  <title>{{ title }}</title>
</head>
<body>
  <div class="page">
    <div class="header">
      <div class="logo">
        <img src="/assets/tokeng-logo.png" alt="Tokeng Logo">
      </div>
      <ul class="header-nav">
        {{ header-nav }}
      </ul>
    </div>
    <div class="pageheader">
      <h1>{{ page-title }}</h1>
    </div>
    <div class="contents">
      {{ contents }}
    </div>
    <div class="footer">
      <ul class="footer-nav">
        <li><a href="/about">about</a></li>
        <li><a href="https://dorkodu.com">dorkodu</a></li>
        <li><a href="https://dorkodu.com/jobs">jobs</a></li>
        <li><a href="/terms">terms</a></li>
      </ul>
      <p>a Dorkodu masterpiece.</p>
      <p>Tokeng &copy; 2021</p>
    </div>
  </div>
</body>
</html>
HTML;

    private UIComponent $component;

    /**
     * Class constructor.
     */
    public function __construct(string $title, string $pageTitle, string $contents, bool $isLoggedIn)
    {
      $dataArray = [
        'title' => $title,
        'page-title' => $pageTitle,
        'header-nav' => $this->renderHeaderLinks($isLoggedIn),
        'contents' => $contents
      ];

      $this->component = new UIComponent($dataArray, $this->template);
    }

    private function renderHeaderLinks(bool $isLoggedIn)
    {
      if ($isLoggedIn) {
        return '<li><a href="/home">home</a></li>
                <li><a href="/me">my profile</a></li>
                <li><a href="/random-match">random</a></li>
                <li><a href="/logout">logout</a></li>';
      } else {
        return '<li><a href="/">frontpage</a></li>
                <li><a href="/about">about</a></li>
                <li><a href="/register">register</a></li>';
      }
    }

    public function render() {
      ob_start();
      echo $this->component->render();
      ob_end_flush();
    }
  }
  