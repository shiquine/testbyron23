<?php

$page_template = $page->intendedTemplate();
$is_home = $page->isHomepage();

$bg_color = $bg_color ?? false;

?><!DOCTYPE html>
<html lang="en-GB" class="no-js">
  <head>

    <?php
    //  Switch 'no-js' with 'js' on <html> if scripts are allowed
    //  http://www.paulirish.com/2009/avoiding-the-fouc-v3/
    ?>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>

    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <?php
    //  Prefetch
    ?>
    <link href="https://www.googletagmanager.com" rel="dns-prefetch">
    <link href="https://www.google-analytics.com" rel="dns-prefetch">

    <?php
    //  SEO
    //  See: https://github.com/pedroborges/kirby-meta-tags
    echo $page->metaTags();
    ?>

    <?php
    //  CSS
    ?>
    <?= css('assets/css/build/style.css?ver=' . filemtime('assets/css/build/style.css')); ?>

    <?php
    //  Sitemap
    ?>
    <link rel="sitemap" type="application/xml" title="Sitemap" href="<?= $site->url() ?>/sitemap.xml">

    <?php
    //  Favicons
    ?>
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $site->url() ?>/assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $site->url() ?>/assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $site->url() ?>/assets/img/favicons/favicon-16x16.png">
    <link rel="manifest" href="<?= $site->url() ?>/assets/img/favicons/site.webmanifest">
    <link rel="mask-icon" href="<?= $site->url() ?>/assets/img/favicons/safari-pinned-tab.svg" color="#dc4f3e">
    <link rel="shortcut icon" href="<?= $site->url() ?>/assets/img/favicons/favicon.ico">
    <meta name="msapplication-TileColor" content="#e9deca">
    <meta name="msapplication-config" content="<?= $site->url() ?>/assets/img/favicons/browserconfig.xml">
    <meta name="theme-color" content="#dc4f3e">

    <?php
    //  Facebook Pixel
    ?>
    <meta name="facebook-domain-verification" content="pwj7r6abm2qyssv3767qi947guqlgf" />

    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '1565607456990317');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=1565607456990317&ev=PageView&noscript=1"
    /></noscript>
  </head>
  <body
    data-template="<?= $page_template; ?>"
    <?php
    if ($bg_color):
    ?>
      style="--background: <?= $bg_color; ?>"
    <?php
    endif;
    ?>
  >

    <?php
    //  Dev
    // snippet('dev');
    ?>

    <header class="Header" data-header>
      <div class="Header-outer">
        <div class="Header-inner">
          <?php
          //  Title
          //  If this is the homepage, make this the H1
          $logo_el = $is_home ? 'h1' : 'div';
          ?>
          <<?= $logo_el; ?> class="Header-logo">
            <a href="<?= $site->url(); ?>" rel="home">
              <span>Byron Burgers</span>
              <?php
              snippet('../../assets/img/vector/logo-byron.svg');
              snippet('../../assets/img/vector/logo-burgers.svg');
              ?>
            </a>
          </<?= $logo_el; ?>>

          <?php
          //  Navicon
          ?>
          <div class="Header-naviconContainer">
            <button
              class="Header-navicon"
              data-nav-button="navicon"
              aria-expanded="false"
              aria-controls="Nav"
              aria-label="Toggle menu"
              data-animation
            ><div
              class="Header-naviconLottie"
              data-path="<?= $kirby->url('assets'); ?>/img/json/burger.json"
              data-hover="true"
              aria-hidden="true"
            ></div></button>

            <?php
            //  Noscript fallback, go to footer menu instead
            ?>
            <noscript>
              <a
                href="#Footer-nav"
                class="Header-navicon"
                aria-label="View menu"
              ><?php snippet('../../assets/img/vector/navicon-arced.svg'); ?></a>
            </noscript>
          </div>
        </div>

        <?php
        //  Main Nav
        snippet('Nav');
        ?>
      </div>
    </header>

