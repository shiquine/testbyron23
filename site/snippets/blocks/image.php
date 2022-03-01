<?php

$image = $block->image()->toFile();
$caption = $block->caption();
$has_caption = $caption->isNotEmpty();
$el = $has_caption ? 'figure' : 'div';

//  The image is required
if (!$image) return;
?>
<<?= $el; ?> class="ImageBlock">
  <?php
  snippet('Image', [
    'image' => $image,
    'srcset' => 'Default',
    'sizes' => '(min-width: 1140px) 1080px, 90vw',
  ]);

  //  Caption
  if ($has_caption):
  ?>
    <figcaption class="ImageBlock-caption"><?= $caption->kt(); ?></figcaption>
  <?php
  endif;
  ?>
</<?= $el; ?>>

