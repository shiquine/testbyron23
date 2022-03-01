<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  return a::merge($site_controller, [
    'allergens' => $page->children()->template('allergen'),
    'ingredients' => $page->children()->template('ingredient'),

    'intro_text' => $page->intro_text(),
    'more_button_text' => $page->more_button_text()->or('Read more about our allergen safety policies'),
    'more_text' => $page->more_text(),

    'guide_pdf' => $page->guide_pdf()->toFile(),
    'guide_text' => $page->guide_text(),
    'no_allergens_text' => $page->no_allergens_text(),
    'menu_categories' =>
      $site
        ->find('Menu')
        ->children()
        ->template('menu_category')
        ->listed()
        ->filter(function ($category) {
          return ($category->hasListedChildren() or $category->hasUnlistedChildren());
        }),
    'end_text' => $page->end_text(),
  ]);
};
