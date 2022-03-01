<?php

//  $campaigns is required
if (!isset($campaigns) || $campaigns->isEmpty()) return;
?>

<div class="Home-campaigns">
  <?php
  snippet('Splide', [
    'list' => $campaigns,
    'type' => 'campaigns',
    'item_snippet' => 'home/campaign',
  ]);
  ?>
</div>
