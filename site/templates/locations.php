<?php
snippet('header');
?>

  <main role="main">
    <div class="Locations" data-locations>
      <?php
      //  Title
      ?>
      <h1 class="Locations-title"><?= $title->escape('html'); ?></h1>

      <?php
      //  Finder
      snippet('locations/Finder', [
        'image' => $finder_image,
      ]);

      //  Container for Error and Results
      ?>
      <div class="Locations-results" data-locations-results>
        <?php
        //  Error
        //  Could come from a param so escape it
        if (!empty($error)):
        ?>
          <div class="Locations-error" role="alert"><?= Escape::html($error); ?></div>
        <?php
        endif;

        //  Locations
        ?>
        <ul class="Locations-list">
          <?php
          foreach ($locations as $location):
            snippet('locations/location', [
              'location' => $location,
            ]);
          endforeach;
          ?>
        </ul>
      </div>
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
