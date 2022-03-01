<?php
snippet('header');
?>

  <main role="main">
    <article class="Article">
      <?php
      //  Banner
      if ($banners->full() or $banners->mobile()):
        $has_both = ($banners->full() and $banners->mobile());
      ?>
        <div class="Article-banner<?= $has_both ? ' Article-banner--swap' : ''; ?>">
          <?php
          if ($banners->full()):
            snippet('Image', [
              'image' => $banners->full(),
              'class' => 'Article-bannerImage Article-bannerImage--full',
              'srcset' => 'Default',
              'sizes' => '100vw',
            ]);
          endif;

          if ($banners->mobile()):
            snippet('Image', [
              'image' => $banners->mobile(),
              'class' => 'Article-bannerImage Article-bannerImage--mobile',
              'srcset' => 'Default',
              'sizes' => '100vw',
            ]);
          endif;
          ?>
        </div>
      <?php
      endif;

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
      ?>
    </article>

    <?php
    //  Stories
    snippet('Stories', [
      'stories' => $stories,
      'element' => 'aside',
    ]);

    snippet('Illustration', [
      'file' => $footer_illustration->illustration(),
      'type' => $footer_illustration->type(),
    ]);
    ?>
  </main>

<?php
snippet('footer');
?>
