<?php
//  TODO: Talk to Guillem about whether some pop-up text is needed for these, like on Honest Burgers, see: https://www.honestburgers.co.uk/food/burgers/plant/. If so, work out how to accessibly make the div version focusable (if needed, or maybe just aria-label and hover?). Ask Guillem to do a design for mobile — how will it go with the left margin? If they aren‘t needed, just make it an aria-label?

//  $text and $abbreviation are required
if (!isset($text) or !isset($abbreviation)) return;

$color = $color ?? 'black';
$href = $href ?? false;

$is_button = $href;
$element = $is_button ? 'button' : 'div';

?>
<<?= $element; ?>
  class="Bubble Bubble--<?= $color; ?>"
  <?= $is_button ? ' data-scroll-to="' . $href . '"' : ''; ?>
>
  <div class="Bubble-abbreviation"><?= $abbreviation; ?></div>
  <div class="Bubble-text"><?= $text; ?></div>
</<?= $element; ?>>
