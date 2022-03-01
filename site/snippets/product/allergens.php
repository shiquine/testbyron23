<?php

$ingredients = $ingredients ?? false;
$preparation_allergens = $preparation_allergens ?? false;

$notices = [
  byron_get_allergen_notice(
    intro: 'This product contains: ',
    list: $ingredients,
  ),
  byron_get_allergen_notice(
    intro: 'During preparation, this product may have come into contact with: ',
    list: $preparation_allergens,
  ),
];

?>
<section class="Product-allergens" id="Product-allergens">
  <div class="Product-allergensInner">
    <h2 class="Product-allergensTitle">Allergen Safety</h2>

    <?php
    //  Notices
    foreach ($notices as $notice):
      if (!$notice) continue;
    ?>
      <p class="Product-allergensNotice"><?= $notice; ?></p>
    <?php
    endforeach;

    //  Link to allergens page
    ?>
    <a href="<?= $site->page('Allergens')->url(); ?>" class="Product-allergensMore">More about allergens</a>
  </div>
</section>
