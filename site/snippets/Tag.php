<?php

//  $text is required
if (!isset($text)) return;

$attrs = $attrs ?? '';
$element = $element ?? 'div';
$color = $color ?? 'blue';

?>
<<?= $element; ?>
  class="Tag Tag--<?= $color; ?>"
  <?= $attrs; ?>
><div class="Tag-inner"><?= $text; ?></div></<?= $element; ?>>
