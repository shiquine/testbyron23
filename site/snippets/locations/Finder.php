<?php

$image = $image ?? false;
?>
<div class="Finder">
  <form
    method="post"
    autocomplete="off"
    novalidate
    action="<?= url('/locations'); ?>"
    data-location-form
  >
    <input
      id="Finder-input"
      type="search"
      name="q"
      value="<?= html($query); ?>"
      autocomplete="postal-code"
      placeholder=" "
    >
    <label for="Finder-input">Enter a town, postcode or location to find your closest Byron</label>
    <button class="Finder-locationButton" data-location-button type="button" aria-label="Use your current location"><?php snippet('../../assets/img/vector/pin.svg'); ?></button>
    <button type="submit">Find</button>
  </form>

  <?php
  //  Image
  if ($image):
  ?>
    <div class="Finder-image">
      <?php
      snippet('Image', [
        'image' => $image,
        'srcset' => 'Default',
        'sizes' => '(min-width: 1140px) 1080px, 90vw',
        'object_fit' => true,
      ]);
      ?>
    </div>
  <?php
  endif;
  ?>
</div>
