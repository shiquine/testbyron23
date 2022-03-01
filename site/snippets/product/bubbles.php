<?php

$ingredients = $ingredients ?? false;

$dietary_preferences = byron_get_dietary_preferences_from_ingredients(
  ingredients: $ingredients,
);

?>
<div class="Product-bubbles">
  <?php
  if ($dietary_preferences):
    foreach ($dietary_preferences as $preference):
      $is_suitable = $preference['is_suitable'];
      if (!$is_suitable) continue;

      $name = $preference['name'];
      $abbreviation = $preference['abbreviation'];
      $text = $preference['text'];

      snippet('Bubble', [
        'abbreviation' => $abbreviation,
        'text' => $text,
        'color' => 'black',
      ]);
    endforeach;
  endif;

  snippet('Bubble', [
    'abbreviation' => 'A',
    'href' => '#Product-allergens',
    'text' => 'View all allergens',
    'color' => 'black',
  ]);
  ?>
</div>
