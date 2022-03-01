<?php

$position = $block->position()->or('left');
$type = $block->link_type()->or('page');
$text = $block->text();
$target_page = $block->page()->toPage();
$url = false;

//  Page
if ($type == 'page') {
  $url = $target_page ? $target_page->url() : false;

//  URL
} elseif ($type == 'url') {
  $url = $block->url();
}

if (!$url or empty($url) or !$text or empty($text)) return;
?>
<a
  href="<?= $url; ?>"
  class="BigLink BigLink--<?= $position->escape('attr'); ?>"
  <?= ($page->url() === $url) ? ' aria-current="page"' : ''; ?>
><span aria-hidden="true">—</span><span class="BigLink-inner"><?= Escape::html($text); ?></span><span aria-hidden="true">—</span></a>
