<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'featured_campaigns' => $page->featured_campaigns()->toPages(),
    'tickertape' => $page->tickertape()->toFile(),
    'video' => new Obj([
      'mp4' => $page->video_720p(),
      'hls' => $page->video_hls(),
    ]),
    'featured_products' => $page->featured_products()->toPages(),
    'stories' => $page->stories()->toPages(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
