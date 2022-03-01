    <?php
    //  TODO: Join Byron Club

    //  Modal
    //  The ID is a hash of the title and text, so we can show the pop-up again
    //  when the content changes
    if ($popup->include()):
      snippet('Modal', [
        'id' => md5($popup->title()->value() . $popup->text()->value()),
        'color' => 'red',
        'snippet' => 'PopUp',
        'content' => $popup,
        'delay' => $popup->delay(),
        'aria_labelledby' => 'PopUp-title PopUp-text',
      ]);
    endif;
    ?>

    <footer class="Footer" role="contentinfo">
      <?php
      //  Socials
      snippet('Socials', [
        'type' => 'footer',
        'instagram' => $instagram,
        'facebook' => $facebook,
        'twitter' => $twitter,
      ]);

      //  Menus
      ?>
      <nav class="Footer-menus">
        <?php
        //  Main Menu (no-js)
        snippet('Footer-menu', [
          'type' => 'main',
          'items' => $menu,
        ]);

        //  Primary Menu
        snippet('Footer-menu', [
          'type' => 'primary',
          'items' => $footer_primary_menu,
        ]);

        //  Secondary Menu
        snippet('Footer-menu', [
          'type' => 'secondary',
          'items' => $footer_secondary_menu,
        ]);
        ?>
      </nav>

      <?php
      //  Copyright Text
      if ($copyright_text->isNotEmpty()):
      ?>
        <div class="Footer-copyright">
          <?= '&copy; ' . $copyright_text->text() . ' ' . date('Y'); ?>
        </div>
      <?php
      endif;
      ?>
    </footer>

    <?php
    //  Cookie Banner
    snippet('CookieBanner');
    ?>

    <?php
    //  Sizing El
    ?>
    <div class="hidden" data-sizingEl></div>

    <?php
    //  JS

    //  Stop LazySizes from running automatically so plugins have a chance to load in browsers that need polyfills.
    //  See: https://github.com/aFarkas/lazysizes
    ?>
    <script>
      window.lazySizesConfig = window.lazySizesConfig || {};
      window.lazySizesConfig.init = false;
    </script>
    <?= js('assets/js/build/bundle.js?ver=' . filemtime('assets/js/build/bundle.js')); ?>

    <?php
    //  Analytics
    snippet('analytics');
    ?>

  </body>
</html>
