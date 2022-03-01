<?php
//  $stories are required
if (!isset($stories) or $stories->isEmpty()) return;

?>
<aside class="Stories Stories--product">
  <ul>
    <?php
    foreach ($stories as $story):
      snippet('Story', [
        'story' => $story,
        'type' => 'product',
      ]);
    endforeach;
    ?>
  </ul>
</aside>
