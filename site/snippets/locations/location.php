<?php

//  $location is required
if (!isset($location)) return;

$delivery_only = $location->delivery_only()->toBool(false);
$delivery_url = $site->page('Order')->delivery_url()->or('');

$title = $location->title();
$url = $delivery_only ? $delivery_url : $location->url();
$image = $location->featured_image()->toFile();
$address = byron_get_address_from_location($location);
$phone = $location->phone();

$link_text = $delivery_only ? 'Order Now' : 'More info';

?>
<li class="Locations-item">
  <h2 class="Locations-itemTitle">
    <a
      href="<?= $url; ?>"
      <?= $delivery_only ? 'target="_blank" rel="noopener noreferrer"': ''; ?>
    ><?= $title->escape('html'); ?><?php
      if ($delivery_only):
        ?><span> — Order Now</span><?php
      else:
        ?><span> — More info</span><?php
      endif;
    ?></a>
  </h2>

  <?php
  //  Image
  ?>
  <div class="Locations-itemImage">
    <?php
    if ($image):
      snippet('Image', [
        'image' => $image,
        'srcset' => 'Default',
        'sizes' => '(min-width: 1140px) 530px, (min-width: 800px) 45vw, 90vw',
        'object_fit' => true,
      ]);
    endif;
    ?>
  </div>

  <?php
  //  Address
  snippet('Address', [
    'address' => $address,
    'phone' => $phone,
  ]);

  //  Link
  ?>
  <a
    href="<?= $url; ?>"
    class="Locations-itemLink"
    aria-hidden="true"
    <?= $delivery_only ? 'target="_blank" rel="noopener noreferrer"': ''; ?>
  ><?= $link_text; ?></a>
</li>
