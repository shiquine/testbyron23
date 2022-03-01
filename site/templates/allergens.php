<?php
snippet('header');
?>

  <main role="main">
    <article class="Allergens">
      <?php
      //  Title
      ?>
      <h1 class="Allergens-title"><?= $title->escape('html'); ?></h1>

      <div class="Allergens-content">
        <?php
        //  Intro
        if ($intro_text->isNotEmpty()):
          echo $intro_text->text();
        endif;

        //  More
        if ($more_text->isNotEmpty()):
          snippet('Expander', [
            'class' => 'Allergens-more',
            'buttonText' => $more_button_text,
            'content' => $more_text->text(),
          ]);
        endif;
        ?>
      </div>

      <?php
      //  Guide
      if ($menu_categories->isNotEmpty()):
      ?>
        <section class="Allergens-guide" data-filter-container>
          <h2 class="Allergens-title">Allergen Guide</h2>

          <?php
          //  PDF Guide
          if ($guide_pdf):
          ?>
            <div class="Allergens-pdf">
              <a class="Button Button--block" href="<?= $guide_pdf->url(); ?>">Download allergen guide</a>
            </div>
          <?php
          endif;

          //  Intro
          if ($guide_text->isNotEmpty()):
          ?>
            <div class="Allergens-content">
              <?= $guide_text->text(); ?>
            </div>
          <?php
          endif;

          //  Filters
          //  TODO: Filtering JS (make into a reusable component)
          //  TODO: Test this in screenreader
          /*
          ?>
          <ul class="Allergens-filters">
            <?php
            foreach ($allergens as $allergen):
              $title = $allergen->title();
              $slug = $allergen->slug();

              snippet('Tag', [
              'element' => 'button',
              'text' => $title,
              'color' => 'red',
              'attrs' => '
                data-filter="' . $slug . '"
                aria-label="Hide products containing ' . $title . '"
              ',
            ]);
            endforeach;
            ?>
          </ul>
          */
          ?>

          <?php
          //  Menu
          ?>
          <div class="Allergens-menu">
            <?php
            foreach ($menu_categories as $category):
              $title = $category->title();

              //  Show both `listed` and `unlisted` here, `published`
              $products = $category->children()->template('product')->published();

              snippet('Expander', [
                'class' => 'Allergens-category',
                'buttonText' => $title,
                'content' => snippet('allergens/products', [
                  'products' => $products,
                  'fallback_text' => $no_allergens_text,
                ], true),
              ]);
            endforeach;
            ?>
          </div>

          <?php
          //  End Text
          if ($end_text->isNotEmpty()):
          ?>
            <div class="Allergens-content">
              <?= $end_text->text(); ?>
            </div>
          <?php
          endif;
          ?>
        </section>
      <?php
      endif;
      ?>

    </article>
  </main>

<?php
snippet('footer');
?>
