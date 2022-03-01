<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'type' => $page->redirect_type()->or('url'),
    'redirect_url' => $page->redirect_url(),
    'redirect_page' => $page->redirect_page()->toPage(),
    'redirect_file' => $page->redirect_file()->toFile(),
  ]);
};
