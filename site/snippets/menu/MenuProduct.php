<?php

//  $item is required
if (!isset($item)) return;
$product = $item;

$title = $product->title();
$url = $product->url();
$image = $product->menu_image()->toFile();
$tag = $product->tag();

?>
<div class="MenuProduct MenuProduct--menu">
  <?php
  //  Title
  ?>
  <h3 class="MenuProduct-title">
    <a href="<?= $url; ?>"><span><?= $title->escape('html'); ?></span></a>
  </h3>

  <?php
  //  Tag
  //  The value is stored as "{text},{color}"
  if ($tag->isNotEmpty()):
    [$text, $color] = $tag->split(',');

    snippet('Tag', [
      'text' => $text,
      'color' => $color,
    ]);
  endif;

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
