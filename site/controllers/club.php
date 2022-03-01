<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  //  Gather the responses to the contact form
  $form_response = byron_handle_club_form_submission($kirby);

  return a::merge($site_controller, [
    'text' => $page->text()->toBlocks(),
    'form_response' => $form_response,
  ]);
};
