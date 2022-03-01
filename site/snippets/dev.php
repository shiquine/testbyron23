<div class="dev-spacer" style="position: absolute; z-index: 1000; pointer-events: none; width: 10px; height: 10px; background-color: red; top: 0; left: 0;"></div>

<?php
//  Grid
$baseline = 0;
?>
<style type="text/css">
  .dev-grid {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    pointer-events: none;

    <?php
    //  Baseline Grid
    if ($baseline): ?>
      background-size: <?= $baseline . ' ' . $baseline; ?>;
      background-image:
        linear-gradient(to top, rgba(255, 0, 0, 0.25) 1px, transparent 1px);
      background-repeat: repeat;
    <?php
    endif; ?>
  }

  .dev-grid.is-active {
    display: block;
  }

  @media screen and (max-width: 1079px) {
    .dev-grid--large,
    .dev-grid--large.is-active {
      display: none;
    }
  }

  .dev-grid-inner {
    display: grid;
    grid-template-columns: repeat(var(--gridColumns), 1fr);
    grid-column-gap: var(--gridGap);
    width: 100%;
    height: 100%;
    max-width: var(--maxWidth);
    margin-right: auto;
    margin-left: auto;
    padding-right: var(--margin);
    padding-left: var(--margin);
  }

  .dev-grid--large .dev-grid-inner {
    position: relative;

    left: 50%;
    transform: translateX(-50%);

    grid-template-columns: repeat(calc(var(--gridColumns) + 4), 1fr);

    width: calc(100vw + (var(--oneColumnOfMaxWidth) * 4) + (var(--gridGap) * 4));
    max-width: var(--extraMaxWidth);

    padding: 0;
    margin: 0;
  }

  .dev-grid-column {
    height: 100%;
    background-color: rgba(0, 0, 255, 0.25);
    mix-blend-mode: hard-light;
  }

  .dev-grid--large .div-grid-column {
    height: 100%;
    background-color: rgba(255, 0, 0, 0.25);
    mix-blend-mode: hard-light;
  }
</style>
<div class="dev-grid" data-dev-grid>
  <div class="dev-grid-inner">
    <?php
    for ($i = 0; $i < 12; $i += 1): ?>
      <div class="dev-grid-column"></div>
    <?php
    endfor; ?>
  </div>
</div>

<div class="dev-grid dev-grid--large" data-dev-grid>
  <div class="dev-grid-inner">
    <?php
    for ($i = 0; $i < 10; $i += 1): ?>
      <div class="dev-grid-column"></div>
    <?php
    endfor; ?>
  </div>
</div>
<script>
  const dev = (function() {
    const grid = Array.from(document.querySelectorAll('[data-dev-grid]'));
    const activeClass = 'is-active';

    function init() {
      if (grid.length) {
        listenForGridToggle();
      }
    }

    function listenForGridToggle() {
      window.addEventListener('keydown', toggleGrid);
    }

    function toggleGrid(e) {
      //  cmd + '
      if ((e.metaKey || e.ctrlKey) && e.keyCode === 222) {
        grid.forEach(item => {
          item.classList.toggle(activeClass);
        });
      }
    }

    return {
      init,
    };
  })();
  dev.init();
</script>
