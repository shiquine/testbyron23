<?php
if ($menu->isEmpty()) return;
?>
<nav
  class="Nav"
  data-nav
  id="Nav"
  role="navigation"
  aria-label="Main Menu"
  tabindex="-1"
>
  <div class="Nav-inner">
    <button
      class="Nav-close"
      data-nav-button="close"
    ><span>Close the menu</span><?php snippet('../../assets/img/vector/cross.svg'); ?></button>

    <ul class="Nav-list">
      <?php
      foreach ($menu as $item):
        $type = $item->type()->or('page');
        $text = $item->text();
        $target_page = $item->page()->toPage();
        $url = false;
        $new_tab = $item->new_tab()->toBool(false);

        //  isOpen is true if a subpage of this page is active too
        $is_open = $target_page ? $target_page->isOpen() : false;

        //  Page
        if ($type == 'page') {
          $url = $target_page ? $target_page->url() : false;

        //  URL
        } elseif ($type == 'url') {
          $url = $item->url();
        }

        if (!$url or empty($url) or !$text or empty($text)) continue;
      ?>
        <li class="Nav-item"><?php
          ?><a
            href="<?= $url; ?>"
            class="Nav-link"
            data-text="<?= Escape::html($text); ?>"
            <?= ($page->url() === $url) ? ' aria-current="page"' : ''; ?>
            <?= $is_open ? ' data-active' : ''; ?>
            <?= $new_tab ? 'target="_blank" rel="noopener noreferrer"': ''; ?>
          ><span><?= Escape::html($text); ?></span></a><?php
        ?></li>
      <?php
      endforeach; ?>
    </ul>
  </div>
</nav>
