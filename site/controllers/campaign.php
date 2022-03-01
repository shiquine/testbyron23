<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'bg_color' => $page->bg_colour()->or('#e9deca'),
    'banners' => new Obj([
      'full' => $page->banner_image()->toFile(),
      'mobile' => $page->banner_image_mobile()->toFile(),
    ]),
    'text' => $page->text()->toBlocks(),
    'stories' => $page->stories()->toPages(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
