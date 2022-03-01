<?php

//  $images are required
if (!isset($images) or !$images or $images->isEmpty()) return;

$ratio = $ratio ?? '56.25%';

?>
<div class="Gallery" data-gallery style="--ratio: <?= $ratio; ?>">
  <?php
  foreach ($images as $image):
    $index = $images->indexOf($image);
  ?>
    <div
      class="Gallery-item"
      data-gallery-item
      data-current
      <?= $index !== 0 ? 'hidden' : ''; ?>
    >
      <?php
      snippet('Image', [
        'image' => $image,
        'srcset' => 'Default',
        'sizes' => '(min-width: 1140px) 530px, (min-width: 800px) 45vw, 90vw',
        'object_fit' => true,

        //  Images must be preloaded for a smooth animation
        'class' => 'lazypreload',
      ]);
      ?>
    </div>
  <?php
  endforeach;
  ?>
</div>
