<?php
//  $item is required
if (!isset($item)) return;
$campaign = $item;

$title = $campaign->title();
$url = $campaign->url();
$image = $campaign->featured_image()->toFile();

?>

<div class="Home-campaign">
  <a
    href="<?= $url; ?>"
    aria-label="<?= $title->escape('attr'); ?>"
  >
    <?php
    if ($image):
      snippet('Image', [
        'container' => true,
        'class' => 'Home-campaignImage',
        'image' => $image,
        'srcset' => 'Default',
        'sizes' => '(min-width: 1140px) 1080px, 90vw',
      ]);
    endif;
    ?>
  </a>
</div>
