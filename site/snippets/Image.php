<?php
//  Image
//  Returns image markup with noscript fallback. Whitespace has to be taken out
//  of this markup, otherwise it will not render correctly within kirbytext.

//  $image is required
if (!isset($image) or !$image) return;

$container = $container ?? false;
$class = $class ?? '';
$src = $src ?? false;
$srcset = $srcset ?? 'Default';
$sizes = $sizes ?? 'auto';
$noscript = $noscript ?? true;
$object_fit = $object_fit ?? false;

$ratio = round(($image->height() / $image->width()), 2);

$is_svg = ($image->extension() === 'svg');
$is_gif = ($image->extension() === 'gif');

if ($container):
?><div
    class="<?= Escape::attr($class); ?>Container"
    style="--ratio: <?= $ratio; ?>"
  ><?php
endif;

?><img
  class="<?= Escape::attr($class); ?> lazyload"
  alt="<?= $image->alt()->or('')->escape('attr'); ?>"
  src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
  style="--ratio: <?= $ratio; ?>"
  <?php
  //  For SVG and GIF, show the full image
  if ($is_svg or $is_gif):
    ?>data-src="<?= $image->url(); ?>" <?php

  //  For other image types, show either single src or an srcset
  elseif ($src):
    ?>data-src="<?= $src; ?>" <?php

  else:
    ?>data-srcset="<?= $image->srcset($srcset); ?>" <?php
  endif;

  //  Only show sizes if it is an srcset being shown
  if (!$src):
    //  For Object Fit
    if ($object_fit):
      ?>data-sizes="auto" data-aspectratio="<?= $ratio; ?>" <?php
    else:
    ?>data-sizes="<?= $sizes; ?>" <?php
    endif;
  endif;
?>/><?php

//  No JS Fallback
if ($noscript): ?>
  <noscript><img
    class="<?= Escape::attr($class); ?> noscript"
    alt="<?= $image->alt()->or('')->escape('attr'); ?>"
    style="--ratio: <?= $ratio; ?>"
    <?php
    //  For SVG and GIF, show the full image
    if ($is_svg or $is_gif):
      ?>src="<?= $image->url(); ?>" <?php

    //  For other image types, show either single src or an srcset
    elseif ($src):
      ?>src="<?= $src; ?>" <?php

    else:
      ?>srcset="<?= $image->srcset($srcset); ?>" <?php
    endif;

    //  Only show sizes if it is an srcset being shown
    if (!$src):
      ?>sizes="<?= $sizes; ?>" <?php
    endif;
  ?>/></noscript><?php
endif;

if ($container):
  ?></div><?php
endif;
?>
