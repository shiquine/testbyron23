<?php

//  $file is required
if (!isset($file) or !$file) return;

$is_json = $file->extension() === 'json';

//  The file must be JSON
if (!$is_json) return;

$url = $file->url();
$type = $type ?? 'scroll';
?>

<div
  class="Illustration"
  data-animation="<?= $url; ?>"
  data-reveal="true"
  <?= ($type == 'scroll') ? 'data-scroll="true"' : ''; ?>
  <?= ($type == 'loop') ? 'data-loop="true"' : ''; ?>
  aria-hidden="true"
></div>
