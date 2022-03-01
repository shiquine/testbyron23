<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'featured_image' => $page->featured_image()->toFile(),
    'delivery_only' => $page->delivery_only()->toBool(false),
    'gallery' => $page->gallery()->toFiles(),
    'opening_hours' => $page->opening_hours()->toStructure(),
    'address' => byron_get_address_from_location($page),
    'phone' => $page->phone(),
    'email' => $page->email(),
    'tags' => $page->tags(),
    'map' => $page->file('map.jpg'),
    'map_caption' => $page->map_caption(),
    'what_three_words' => $page->what_three_words(),
    'description' => $page->description(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
