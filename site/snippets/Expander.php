<?php

//  $content is required
if (!isset($content) or !$content) return;

$buttonText = $buttonText ?? 'See more';
$class = $class ?? false;
?>

<div class="Expander<?= $class ? ' ' . $class : ''; ?>" data-expander>
  <button
    class="Expander-button"
    data-expander-button
    aria-expanded="false"
  ><?= Escape::html($buttonText); ?><span></span></button>

  <div class="Expander-content" data-expander-parent>
    <div class="Expander-contentInner" data-expander-child>
      <?= $content; ?>
    </div>
  </div>
</div>
