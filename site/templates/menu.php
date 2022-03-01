<?php
snippet('header');
?>

  <main role="main">
    <div class="Menu">
      <h1 class="Menu-title"><?= $title->escape('html'); ?></h1>

      <?php
      $count = 0;
      foreach ($categories as $category):
        $count += 1;
        snippet('menu/MenuCategory', [
          'category' => $category,
          'all_products' => $all_products,
          'next' => $categories->nth($count),
        ]);
      endforeach;

      //  Link to allergens page
      ?>
      <div class="Menu-allergensLink"><a href="<?= $site->page('Allergens')->url(); ?>">View full menu and allergens</a></div>
    </div>

    <?php
    //  Join Byron Club
    snippet('Club');

    snippet('Illustration', [
      'file' => $footer_illustration->illustration(),
      'type' => $footer_illustration->type(),
    ]);
    ?>
  </main>

<?php
snippet('footer');
?>
