<?php

//  $products is required
if (!isset($products) || !$products) return;
?>
<div class="Home-products">
  <h2 class="Home-productsTitle">Menu Highlights</h2>
  <?php
  snippet('Splide', [
    'list' => $products,
    'item_snippet' => 'home/HomeProduct',
  ]);
  ?>
</div>
