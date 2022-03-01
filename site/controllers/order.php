<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'intro' => $page->intro(),
    'collection' => new Obj([
      'image' => $page->collection_image()->toFile(),
      'title' => $page->collection_title(),
      'url' => $page->collection_url(),
    ]),
    'delivery' => new Obj([
      'image' => $page->delivery_image()->toFile(),
      'title' => $page->delivery_title(),
      'url' => $page->delivery_url(),
    ]),
    'stories' => $page->stories()->toPages(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
