<?php
//  From Splide this will be passed $item, not $story

$story = $story ?? $item;

//  $story is required
if (!isset($story) or !$story->exists()) return;

$type = $type ?? 'carousel';
$is_product = $type === 'product';

$element = $is_product ? 'li' : 'div';

$media = $is_product ? $story->regular_media()->toFile() : $story->cropped_media()->toFile();
if (!$media) return;

$title = $story->title();
$description = $story->description();

$link_type = $story->link_type()->or('none');
$link_text = $story->link_text()->or('Find out more');
$url = false;

if ($link_type == 'internal') {
  $url = $story->link_page()->isNotEmpty() ? $story->link_page()->toPage()->url() : false;
} elseif ($link_type == 'external') {
  $url = $story->link_url()->isNotEmpty() ? $story->link_url() : false;
}
?>
<<?= $element; ?> class="Story Story--<?= $type; ?>">
  <?php
  //  Title
  ?>
  <h2 class="Story-title"><?= $title->escape('html'); ?></h2>

  <?php
  //  Media
  if ($media):
    $media_type = $media->type();
    ?>
    <div class="Story-media">
      <?php
      //  Image
      if ($media_type == 'image'):
        snippet('Image', [
          'image' => $media,
          'srcset' => 'Default',
          'sizes' => '(min-width: 1140px) 530px, (min-width: 800px) 45vw, 90vw',
          'object_fit' => !$is_product,
        ]);

      //  Video
      elseif ($media_type == 'video'):
      ?>
        <video
          autoplay
          loop
          muted
          playsinline
          preload="none"
          src="<?= $media->url(); ?>"
        ></video>
      <?php
      endif;
      ?>
    </div>
  <?php
  endif;

  //  Description
  if ($is_product && $description->isNotEmpty()):
  ?>
    <div class="Story-description">
      <?= $description->kt(); ?>
    </div>
  <?php
  endif;

  //  Link
  if ($url):
  ?>
    <a href="<?= Escape::attr($url); ?>" class="Story-link"><?= $link_text->escape('html'); ?></a>
  <?php
  endif;
  ?>
</<?= $element; ?>>
