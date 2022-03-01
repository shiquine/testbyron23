<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'hero_image' => $page->hero_image()->toFile(),
    'tag' => $page->tag(),
    'description' => $page->description(),
    'ingredients' => $page->ingredients()->toPages(),
    'preparation_allergens' => $page->preparation_allergens()->toPages(),
    'stories' => $page->stories()->toPages(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
