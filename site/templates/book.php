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
      //  Content
      if ($text->isNotEmpty()):
      ?>
        <div class="Article-content">
          <?= $text; ?>
        </div>
      <?php
      endif;

      //  Live Res
      snippet('book/liveres');
      ?>

    </article>
  </main>

<?php
snippet('footer');
?>
