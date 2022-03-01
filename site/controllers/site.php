<?php

return function ($kirby, $site, $page) {
  return [
    'title' => $page->title(),

    //  Menu
    'menu' => $site->header_menu()->toStructure(),

    //  Locations (for Byron Club)
    'locations' => $site->index()->template('location')->listed()->sort(),

    //  Social Media
    'twitter' => $site->twitter(),
    'facebook' => $site->facebook(),
    'instagram' => $site->instagram(),

    //  Pop-Up
    'popup' => new Obj([
      'include' => $site->pop_up_toggle()->toBool(false),
      'delay' => $site->pop_up_delay_in_seconds()->or(5),
      'title' => $site->pop_up_title(),
      'text' => $site->pop_up_text(),
      'link_type' => $site->pop_up_link_type()->or('page'),
      'link_text' => $site->pop_up_link_text()->or('See More'),
      'link_page' => $site->pop_up_link_page()->toPage(),
      'link_url' => $site->pop_up_link_url(),
      'media_type' => $site->pop_up_media_type()->or('image'),
      'image' => $site->pop_up_image()->toFile(),
      'illustration' => $site->pop_up_illustration()->toFile(),
    ]),

    //  Footer
    'footer_primary_menu' => $site->footer_primary_menu()->toStructure(),
    'footer_secondary_menu' => $site->footer_secondary_menu()->toStructure(),
    'copyright_text' => $site->copyright_text(),
  ];
};
