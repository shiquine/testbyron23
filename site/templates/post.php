<?php
snippet('header');
?>

  <main role="main">
    <article class="Article">
      <?php
      //  Title
      ?>
      <h1 class="Article-title"><?= $title->escape('html'); ?></h1>

      <?php
      //  Date
      if (!empty($published_date)):
      ?>
        <div class="Article-date"><?= Escape::html($published_date); ?></div>
      <?php
      endif;

      //  Content
      if ($text->isNotEmpty()):
      ?>
        <div class="Article-content">
          <?= $text; ?>
        </div>
      <?php
      endif;

      //  Sibling Links
      //  TODO: aside, nav?
      if ($has_sibling_links):
      ?>
        <div class="Article-links<?= $has_next_sibling_only ? ' Article-links--nextOnly' : ''; ?>">
          <?php
          if ($prev_sibling):
          ?>
            <a href="<?= $prev_sibling->url(); ?>" class="Article-prev"><?= $prev_sibling->title()->escape('html'); ?></a>
          <?php
          endif;

          if ($next_sibling):
          ?>
            <a href="<?= $next_sibling->url(); ?>" class="Article-next"><?= $next_sibling->title()->escape('html'); ?></a>
          <?php
          endif;
          ?>
        </div>
      <?php
      endif;
      ?>

    </article>
  </main>

<?php
snippet('footer');
?>
