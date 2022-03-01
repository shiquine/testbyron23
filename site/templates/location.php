<?php

//  Redirect to the Locations page if this is delivery only
if ($delivery_only) {
  go('/locations');
}

snippet('header');
?>

  <main role="main">
    <article class="Location">
      <?php
      //  Title
      ?>
      <h1 class="Location-title">Byron <?= $title->escape('html'); ?></h1>

      <?php
      //  Gallery
      snippet('Gallery', [
        'images' => $gallery,
        'ratio' => '71.43%', // 5:7
      ]);
      ?>

      <div class="Location-contentTop">
        <?php
        //  Opening Hours
        snippet('location/OpeningHours', [
          'opening_hours' => $opening_hours,
        ]);

        //  Address
        snippet('Address', [
          'address' => $address,
          'phone' => $phone,
          'email' => $email,
        ]);

        //  Tags
        if ($tags->isNotEmpty()):
        ?>
          <ul class="Location-tags">
            <?php
            foreach ($tags->split() as $tag):
            ?>
              <li><?= Str::lower(Escape::html($tag)); ?></li>
            <?php
            endforeach;
            ?>
          </ul>
        <?php
        endif;
        ?>
      </div>

      <?php
      //  Map
      //  For attribution requirement, see: https://docs.mapbox.com/help/getting-started/attribution/#static--print
      if ($map):
      ?>
        <figure class="Location-map">
          <a href="<?= $address->url(); ?>">
            <?php
            snippet('Image', [
              'image' => $map,
              'srcset' => 'Default',
              'sizes' => '(min-width: 1140px) 1080px, 90vw',
            ]);

            snippet('../../assets/img/vector/byron-pin.svg');
            ?>
          </a>
          <figcaption aria-hidden="true">
            &copy; <a href='https://www.mapbox.com/about/maps/'>Mapbox</a> &copy; <a href='http://www.openstreetmap.org/copyright'>OpenStreetMap</a>
          </figcaption>
        </figure>
      <?php
      endif;
      ?>

      <div class="Location-contentBottom">
        <?php
        //  Map Caption
        if ($map_caption->isNotEmpty()):
        ?>
          <div class="Location-mapCaption">
            <?= $map_caption->text(); ?>
          </div>
        <?php
        endif;

        //  what3words
        if ($what_three_words->isNotEmpty()):
        ?>
          <div class="Location-wtw">
            <span>what3words: </span><a href="https://what3words.com/<?= $what_three_words->escape('attr'); ?>">///<?= $what_three_words->escape('html'); ?></a>
          </div>
        <?php
        endif;

        //  Description
        if ($description->isNotEmpty()):
        ?>
          <div class="Location-description">
            <?= $description->text(); ?>
          </div>
        <?php
        endif;

        //  Back Link
        ?>
        <a href="<?= $page->parent()->url(); ?>" class="Location-back">Back to Locations</a>
      </div>

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
