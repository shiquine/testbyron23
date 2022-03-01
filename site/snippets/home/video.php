<?php

$mp4 = $mp4 ?? false;
$hls = $hls ?? false;

if ((!$mp4 or $mp4->isEmpty()) and (!$hls or $hls->isEmpty()))
?>
<div
  class="Video"
  data-video-container
  data-muted
>
  <button
    class="Video-play"
    data-video-play-toggle
  ><span class="Video-playText">Play</span><span class="Video-pauseText">Pause</span></button>

  <button
    class="Video-mute"
    data-video-mute-toggle
  ><span class="Video-muteText">Mute</span><span class="Video-unmuteText">Unmute</span><?php snippet('../../assets/img/vector/muted.svg'); ?><?php snippet('../../assets/img/vector/unmuted.svg'); ?></button>

  <video
    data-video
    autoplay
    loop
    muted
    playsinline
    preload="metadata"
    crossorigin="anonymous"
  >
    <?php
    if ($hls and $hls->isNotEmpty()):
    ?>
      <source src="<?= $hls->escape('attr'); ?>" type="application/x-mpegURL">
    <?php
    endif;

    if ($mp4 and $mp4->isNotEmpty()):
    ?>
      <source src="<?= $mp4->escape('attr'); ?>" type="video/mp4">
    <?php
    endif;
    ?>
  </video>
</div>
