<?php
//  This can either show links to Byron’s social channels, or provide sharing links

$type = $type ?? 'regular';

$url = $url ?? false;
$title = $title ?? false;

$is_share = ($url and $title and isset($type) and ($type === 'share'));
$is_links = !$is_share;

$show_instagram = (isset($instagram) and $instagram and $instagram->isNotEmpty());
$show_facebook = (isset($facebook) and $facebook and $facebook->isNotEmpty());
$show_twitter = (isset($twitter) and $twitter and $twitter->isNotEmpty());

?>

<div class="Socials Socials--<?= $type; ?>">
  <ul class="Socials-list">
    <?php
    //  Instagram
    if ($show_instagram): ?>
      <li class="Socials-item Socials-item--instagram">
        <a
          href="<?= $instagram->escape('attr'); ?>"
          target="_blank"
          rel="noopener noreferrer"
          aria-label="Byron on Instagram"
        >
          <?php
          snippet('../../assets/img/vector/instagram.svg');
          ?>
        </a>
      </li>
    <?php
    endif;

    //  Facebook
    if ($show_facebook): ?>
      <li class="Socials-item Socials-item-facebook">
        <a
          <?php
          //  Link to Facebook profile
          if ($is_links):
          ?>
            href="<?= $facebook->escape('attr'); ?>"
            aria-label="Byron on Facebook"
          <?php
          //  Share
          else:
          ?>
            href="https://facebook.com/sharer/sharer.php?u=<?= $url; ?>"
            aria-label="Share on Facebook"
          <?php
          endif;
          ?>
        >
          <?php
          snippet('../../assets/img/vector/facebook.svg');
          ?>
        </a>
      </li>
    <?php
    endif;

    //  Twitter
    if ($show_twitter):
    ?>
      <li class="Socials-item Socials-item--twitter">
        <a
          <?php
          //  Link to Twitter profile
          if ($is_links):
          ?>
            href="https://twitter.com/<?= $twitter->escape('attr'); ?>"
            aria-label="Byron on Twitter"
          <?php
          //  Share
          else:
          ?>
            href="https://twitter.com/intent/tweet?text=<?= $title->escape('attr'); ?>&url=<?= $url; ?>&via=<?= $twitter->escape('attr'); ?>"
            aria-label="Share on Twitter"
          <?php
          endif;
          ?>
        >
          <?php
          snippet('../../assets/img/vector/twitter.svg');
          ?>
        </a>
      </li>
    <?php
    endif;
    ?>
  </ul>
</div>
