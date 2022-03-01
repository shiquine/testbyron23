<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'title' => $page->title(),
    'categories' => $page->children()->template('menu_category')->listed(),
    'all_products' => $page->index()->template('product')->listed(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
