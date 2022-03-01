<?php

//  Required fields $slide_snippet is required
if (!isset($list) or !isset($item_snippet)) return;

$type = $type ?? 'menu';
$has_multiple_slides = (count($list) > 1);
?>

<div
  class="splide"
  data-slider="<?= $type; ?>"
  <?= !$has_multiple_slides ? 'data-single' : ''; ?>
>
	<div class="splide__track">
		<ul class="splide__list">
      <?php
      foreach ($list as $item):
      ?>
        <li class="splide__slide" data-slide>
          <?php
          snippet($item_snippet, [
            'item' => $item,
          ]);
          ?>
        </li>
      <?php
      endforeach;
      ?>
		</ul>
	</div>

  <?php
  //  Buttons
  ?>
  <div class="splide__arrows">
    <button class="splide__arrow splide__arrow--prev"><div class="splide__arrowInner"><?php snippet('../../assets/img/vector/chevron-left.svg'); ?></span></button>
    <button class="splide__arrow splide__arrow--next"><div class="splide__arrowInner"><?php snippet('../../assets/img/vector/chevron-right.svg'); ?></div></button>
  </div>
</div>
