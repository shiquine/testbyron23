<?php
//  For A11Y, see: https://developer.yoast.com/blog/the-a11y-monthly-making-modals-accessible/ and https://www.w3.org/TR/wai-aria-practices-1.1/examples/dialog-modal/dialog.html

//  $snippet, $id and $content are required
if (!isset($snippet) || !isset($id) || !isset($content)) return;

$color = $color ?? 'red';
$delay = $delay ?? false;
$aria_labelledby = $aria_labelledby ?? false;

?>

<div
  class="Modal Modal--<?= $color; ?>"
  data-modal="<?= $id; ?>"
  <?= $delay ? 'data-delay="' . Escape::attr($delay) . '"' : ''; ?>
  tabindex="-1"
  role="dialog"
  aria-modal="true"
  <?= $aria_labelledby ? 'aria-labelledby="' . Escape::attr($aria_labelledby) . '"' : ''; ?>
>
  <div class="Modal-outer">
    <div class="Modal-inner" data-modal-inner>
      <button
        class="Modal-close"
        data-modal-close
      ><span>Close this Pop Up</span><?php snippet('../../assets/img/vector/cross.svg'); ?></button>

      <?php
      snippet($snippet, [
        'content' => $content,
      ]);
      ?>
    </div>
  </div>
</div>
