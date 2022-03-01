<?php
//  $products are required
if (!isset($products) or $products->isEmpty()) return;

$fallback_text = $fallback_text ?? false;
?>
<div class="Allergens-products">
  <?php
  foreach ($products as $product):
    $title = $product->title();
    $url = $product->url();
    $ingredients = $product->ingredients()->toPages();

    $allergen_notice = byron_get_allergen_notice(
      list: $ingredients,
      fallback: $fallback_text,
    );

    $allergen_array = byron_get_allergen_array(
      list: $ingredients,
    );

  ?>
    <div
      class="Allergen-product"
      data-filters="<?= join(', ', array_map('Str::slug', $allergen_array)); ?>"
    >
      <h4 class="Allergen-productTitle"><a href="<?= $url; ?>"><?= $title->escape('html'); ?></a></h4>
      <div class="Allergen-productNotice"><?= $allergen_notice; ?></div>
    </div>
  <?php
  endforeach;
  ?>
</div>
