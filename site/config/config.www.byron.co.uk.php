<?php

return [
  //  Force assets to always be loaded via HTTPS
  //  There was once an issue where a cached page tried to load a stylesheet
  //  over HTTP, causing a mixed content warning
  'url' => 'https://www.byron.co.uk',
];
