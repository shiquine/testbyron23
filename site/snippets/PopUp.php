<?php

//  $content is required
if (!isset($content) or $content->isEmpty()) return;

$title = $content->title();
$text = $content->text();
$link_type = $content->link_type();
$link_text = $content->link_text();
$link_page = $content->link_page();
$link_url = $content->link_url();
$url = false;

$media_type = $content->media_type();
$image = $content->image();
$illustration = $content->illustration();

//  Page
if ($link_type == 'page') {
  $url = $link_page ? $link_page->url() : false;

//  URL
} elseif ($link_type == 'url') {
  $url = $link_url;
}

//  Only continue if there is something to show
if ($title->isEmpty() and $text->isEmpty() and (!$url or $url->isEmpty())) return;
?>
<div class="PopUp">
  <?php
  //  Title
  if ($title->isNotEmpty()):
  ?>
    <h2 class="PopUp-title" id="PopUp-title"><?= $title->escape('html'); ?></h2>
  <?php
  endif;

  //  Text
  if ($text->isNotEmpty()):
  ?>
    <div class="PopUp-text" id="PopUp-text">
      <?= $text->text(); ?>
    </div>
  <?php
  endif;

  //  Link
  if ($url):
  ?>
    <div class="PopUp-link">
      <a href="<?= Escape::attr($url); ?>"><?= $link_text->escape('html'); ?></a>
    </div>
  <?php
  endif;

  //  Image
  if ($media_type == 'image' and $image):
  ?>
    <div class="PopUp-image">
      <?php
      snippet('Image', [
        'image' => $image,
        'srcset' => 'Default',
        'sizes' => '400px',
      ]);
      ?>
    </div>
  <?php
  endif;

  //  Illustration
  if ($media_type == 'animation' and $illustration):
  ?>
    <div class="PopUp-illustration">
      <div
        class="PopUp-illustrationInner"
        data-animation="<?= $illustration->url(); ?>"
        data-autoplay="false"
        data-loop="true"
        data-scroll="false"
        data-reveal="true"
      ></div>
    </div>
  <?php
  endif;
  ?>
</div>
