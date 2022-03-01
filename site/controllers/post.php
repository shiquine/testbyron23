<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  $next_sibling = $page->nextListed();
  $prev_sibling = $page->prevListed();
  $has_sibling_links = ($next_sibling or $prev_sibling);
  $has_next_sibling_only = ($next_sibling and !$prev_sibling);

  return a::merge($site_controller, [
    'text' => $page->text()->toBlocks(),
    'published_date' => $page->published_date()->toDate('jS F Y'),
    'has_sibling_links' => $has_sibling_links,
    'has_next_sibling_only' => $has_next_sibling_only,
    'next_sibling' => $next_sibling,
    'prev_sibling' => $prev_sibling,
  ]);
};
