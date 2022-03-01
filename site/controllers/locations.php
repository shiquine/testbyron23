<?php

return function ($kirby, $site, $page) {
  $site_controller = $kirby->controller('site' , compact('kirby', 'site', 'page'));

  //  Get all locations
  $locations = $page->children()->template('location')->listed()->sort();

  //  Handle Errors
  $error = urldecode(param('error'));

  //  Look for coordinates send directly in the URL. These come if the visitor
  //  is using their own location
  $param_coordinates = [param('lng'), param('lat')];

  $has_param_coordinates = (
    !empty($param_coordinates[0]) &&
    !empty($param_coordinates[1])
  );

  //  Get the query. This matches the `name` of the input
  $query = get('q');

  //  Use param
  if ($has_param_coordinates) {
    //  Sort locations by their distance (as the crow flies) from the query
    $locations = byron_order_locations_by_proximity_to_coordinates($locations, $param_coordinates);

  //  Use the query
  } else {
    //  Send the query to the API function
    $api_result = $query ? byron_get_coordinates_from_query($query) : [];

    //  An error will be returned if the API function comes back false
    $api_error = ($query and empty($api_result));

    //  Check the API comes back...
    $api_success = !empty($api_result);

    //  ...and whether it has results
    $results_found = ($api_success and !empty($api_result['features']));
    $no_result_found = ($query and !$results_found);

    //  Get the coordinates [lng, lat]
    $query_coordinates = $results_found ? $api_result['features'][0]['center'] : [];
    $coordinates_found = !empty($query_coordinates);

    if ($coordinates_found) {
      //  Sort locations by their distance (as the crow flies) from the query
      $locations = byron_order_locations_by_proximity_to_coordinates($locations, $query_coordinates);
    }

    //  Handle Errors
    if ($api_error) {
      $error = $page->error_message_api()->or('There was an error processing your search... but all of our locations are shown alphabetically below.');
    } elseif ($no_result_found) {
      $error = $page->error_message_no_results()->or('No results were found for your search... but all of our locations are shown alphabetically below.');
    }
  }

  return a::merge($site_controller, [
    'query' => $query,
    'error' => $error,
    'locations' => $locations,
    'finder_image' => $page->finder_image()->toFile(),
    'footer_illustration' => byron_get_footer_illustration($page),
  ]);
};
