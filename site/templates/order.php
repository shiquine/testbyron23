<?php
snippet('header');
?>

  <main role="main">
    <div class="Order">
      <?php
      //  Title
      ?>
      <h1 class="Order-title"><?= $title->escape('html'); ?></h1>

      <?php
      //  Intro
      if ($intro->isNotEmpty()):
      ?>
        <div class="Order-intro">
          <div class="Order-introInner">
            <?= $intro->text(); ?>
          </div>
        </div>
      <?php
      endif;

      //  Links
      ?>
      <div class="Order-links">
        <?php
        //  TODO: Add Facebook Pixel code in here? Mentioned in the design
        foreach ([$collection, $delivery] as $item):
          $image = $item->image();
          $title = $item->title();
          $url = $item->url();

          //  Required
          if ($title->isEmpty() or $url->isEmpty()) continue;
        ?>
          <a class="Order-link" href="<?= $url->escape('attr'); ?>" target="_blank" rel="noopener noreferrer">
            <?php
            //  Title
            ?>
            <div class="Order-linkTitle"><?= $title->escape('html'); ?></div>

            <?php
            //  Image
            if ($image):
              snippet('Image', [
                'image' => $image,
                'srcset' => 'Default',
                'sizes' => '(min-width: 1140px) 530px, (min-width: 800px) 45vw, 90vw',
                'object_fit' => true,
              ]);
            endif;
            ?>
          </a>
        <?php
        endforeach;
        ?>
      </div>

      <?php
      //  Join Byron Club
      snippet('Club');

      //  Stories
      snippet('Stories', [
        'stories' => $stories,
      ]);
      ?>

    </div>

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
