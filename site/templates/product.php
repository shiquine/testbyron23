<?php
snippet('header');
?>

  <main role="main">
    <article class="Product">
      <div class="Product-top">
        <?php
        //  Image
        if ($hero_image):
        ?>
          <div class="Product-image">
            <?php
            snippet('Image', [
              'image' => $hero_image,
              'srcset' => 'Default',
              'sizes' => '(min-width: 1140px) 530px, (min-width: 800px) 45vw, 90vw',
              'object_fit' => true,
            ]);
            ?>
          </div>
        <?php
        endif;
        ?>

        <div class="Product-topContent">
          <?php
          //  Title
          ?>
          <h1 class="Product-title"><?= $title->escape('html'); ?></h1>

          <?php
          //  Tag
          //  The value is stored as "{text},{color}"
          if ($tag->isNotEmpty()):
            [$text, $color] = $tag->split(',');

            snippet('Tag', [
              'text' => $text,
              'color' => $color,
            ]);
          endif;

          //  Description
          if ($description->isNotEmpty()):
          ?>
            <div class="Product-description">
              <?= $description->text(); ?>
            </div>
          <?php
          endif;

          //  Dietary Bubbles
          snippet('product/bubbles', [
            'ingredients' => $ingredients,
          ]);

          //  Links
          ?>
          <div class="Product-links">
            <a href="<?= $site->page('Menu')->url(); ?>">Back to menu</a>
            <a href="<?= $site->page('Order')->url(); ?>">Order</a>
          </div>
        </div>
      </div>

      <?php
      //  Allergens
      snippet('product/allergens', [
        'ingredients' => $ingredients,
        'preparation_allergens' => $preparation_allergens,
      ]);

      //  Stories
      snippet('product/stories', [
        'stories' => $stories,
      ]);

      //  Join Byron Club
      snippet('Club');
      ?>

    </article>

    <?php
    snippet('Illustration', [
      'file' => $footer_illustration->illustration(),
      'type' => $footer_illustration->type(),
    ]);
    ?>
  </main>

<?php
snippet('footer');
?>
