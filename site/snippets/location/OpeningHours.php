<?php

//  $opening_hours is required
if (!isset($opening_hours) || $opening_hours->isEmpty()) return;

$grouped_opening_hours = byron_get_grouped_opening_hours($opening_hours);

?>
<section class="OpeningHours">
  <h2 class="OpeningHours-title">Opening Hours</h2>

  <ul>
    <?php
    foreach ($grouped_opening_hours as $item):
      $start_day = $item['start_day'];
      $end_day = $item['end_day'];
      $opening_time = $item['opening_time'];
      $closing_time = $item['closing_time'];

      //  Most are required
      if ($start_day->isEmpty() or $opening_time->isEmpty() or $closing_time->isEmpty()) continue;
    ?>
      <li>
        <span><?= $start_day->escape('html'); ?><?= $end_day ? ' &ndash; ' . $end_day->escape('html') : ''; ?></span>
        <span><?= $opening_time->toDate('g:i a') . ' &ndash; ' . $closing_time->toDate('g:i a'); ?></span>
      </li>
    <?php
    endforeach;
    ?>
  </ul>
</section>
