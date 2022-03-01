<?php

//  $category is required
if (!isset($category)) return;

$title = $category->title();
$products = $category->children()->template('product')->listed();

//  Find and add products that have this category among their
//  secondary categories
$secondary_products = $all_products->filter(function ($product) use ($category) {
  return $product->secondary_categories()->toPages()->has($category);
});

$products = $products->add($secondary_products);

$next = $next ?? false;

//  $products are required
if ($products->isEmpty()) return;

?>
<section class="MenuCategory" id="<?= $title->slug(); ?>">
  <h2 class="MenuCategory-title"><?= $title->escape('html'); ?></h2>

  <?php
  //  Skip to next category button
  if ($next):
  ?>
    <a href="#<?= $next->title()->slug(); ?>" class="MenuCategory-skip">
      <div>Skip to next Menu section</div>
    </a>
  <?php
  endif;

  //  Splide
  snippet('Splide', [
    'list' => $products,
    'item_snippet' => 'menu/MenuProduct',
  ]);
  ?>
</section>
