<?php

//  $items are required
if (!isset($items) or $items->isEmpty()) return;

$type = $type ?? 'primary';
?>
<ul
  class="Footer-menu Footer-menu--<?= $type; ?>"
  <?= $type === 'main' ? 'id="Footer-nav"' : ''; ?>
>
  <?php
  foreach ($items as $item):
    $type = $item->type()->or('url');
    $is_page = ($type == 'page');

    $text = $item->text();
    $page = $item->page()->toPage();
    $url = ($is_page and $page) ? $page->url() : $item->url();
    $new_tab = $item->new_tab()->toBool(false);

    if ($text->isEmpty() or !$url or empty($url)) continue;
  ?>
    <li>
      <a
        href="<?= $url; ?>"
        <?= $new_tab ? 'target="_blank" rel="noopener noreferrer"': ''; ?>
      ><?= $text->escape('html'); ?></a>
    </li>
  <?php
  endforeach;
  ?>
</ul>
