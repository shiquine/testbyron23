<?php

$url = false;

if ($type == 'url' and $redirect_url->isNotEmpty()) {
  $url = $redirect_url;
} elseif ($type == 'page' and $redirect_page) {
  $url = $redirect_page->url();
} elseif ($type == 'file' and $redirect_file) {
  $url = $redirect_file->url();
}

//  If there isn’t a URL, go 404
if (!$url) {
  go('/error');
} else {
  go($url, 302);
}
