<?php
snippet('header');
?>

  <main role="main">
    <div class="Home">
      <?php
      //  Featured Campaign
      snippet('home/campaigns', [
        'campaigns' => $featured_campaigns,
      ]);

      //  Tickertape
      if ($tickertape):
      ?>
        <div class="Home-tickertape">
          <?php
          snippet('Image', [
            'image' => $tickertape,
            'srcset' => 'Default',
            'sizes' => '(min-width: 1140px) 1080px, 90vw',
          ]);
          ?>
        </div>
      <?php
      endif;

      //  Video
      snippet('home/video', [
        'mp4' => $video->mp4(),
        'hls' => $video->hls(),
      ]);

      //  Featured Products
      snippet('home/products', [
        'products' => $featured_products,
      ]);

      //  Buttons
      ?>
      <div class="Home-buttons">
        <a href="<?= url('/locations'); ?>">Find a Byron</a>
        <a href="<?= url('/order'); ?>">Order Now</a>
      </div>

      <?php
      //  Stories
      snippet('Stories', [
        'stories' => $stories,
      ]);

      //  Join Byron Club
      snippet('Club');
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
