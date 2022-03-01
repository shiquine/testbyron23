<?php

//  Additional Functions
include __DIR__ . '/functions.php';

Kirby::plugin('byron/site', [
  'blueprints' => [
    'blocks/bigLink' => __DIR__ . '/blueprints/blocks/bigLink.yml',
  ],
  'snippets' => [
    'blocks/bigLink' => __DIR__ . '/snippets/blocks/bigLink.php',
  ],
]);
