<?php

return [
  //  Debug
  'debug' => true,

  //  Force assets to always be loaded via HTTPS
  //  There was once an issue where a cached page tried to load a stylesheet
  //  over HTTP, causing a mixed content warning
  'url' => 'https://staging.byron.co.uk',

  //  Cache
  //  See: https://getkirby.com/docs/guide/cache
  'cache' => [
    'pages' => [
      'active' => true,
    ]
  ],
];
