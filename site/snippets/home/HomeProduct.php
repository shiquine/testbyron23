<?php

//  $item is required
if (!isset($item)) return;
$product = $item;

$title = $product->title();
$url = $product->url();
$image = $product->menu_image()->toFile();

?>
<div class="MenuProduct MenuProduct--home">
  <?php
  //  Title
  ?>
  <div class="MenuProduct-title">
    <a href="<?= $url; ?>"><span><?= $title->escape('html'); ?></span></a>
  </div>

  <?php
  //  Image
  ?>
  <div class="MenuProduct-image">
    <?php
    if ($image):
      snippet('Image', [
        'image' => $image,
        'srcset' => 'Default',
        'sizes' => '(min-width: 1140px) 360px, (min-width: 800px) 33vw, 66vw',
      ]);
    endif;
    ?>
  </div>
</div>
