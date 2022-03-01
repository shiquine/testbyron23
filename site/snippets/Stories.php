<?php

//  $stories are required
if (!isset($stories) or $stories->isEmpty()) return;

$element = $element ?? 'div';

?>
<<?= $element; ?> class="Stories Stories--carousel">
  <?php
  snippet('Splide', [
    'list' => $stories,
    'type' => 'stories',
    'item_snippet' => 'Story',
  ]);
  ?>
</<?= $element; ?>>
