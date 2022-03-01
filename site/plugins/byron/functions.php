<?php

/*
 * Allergen Notice
 * Return a notice like: 'This product contains: Eggs, Garlic, Soybeans'
 *
 * byron_get_allergen_notice(
 *   intro: 'This product contains: ',
 *   ingredients: $ingredients,
 * );
 *
 * byron_get_allergen_notice(
 *   intro: 'During preparation, this product may have come into contact with :',
 *   allergens: $preparation_allergens,
 * ),
 *
 */

function byron_get_allergen_notice($intro = '', $list = false, $fallback = false) {
  //  Required arguments
  if (!$list) return false;

  $allergens = byron_get_allergen_array(
    list: $list,
  );

  if (empty($allergens)) return $fallback;

  return $intro . join(', ', $allergens);
}

function byron_get_allergen_array($list = false) {
  //  Required arguments
  if (!$list) return false;

  //  Required arguments
  if (!$list) return false;

  $allergens = [];

  foreach ($list as $item) {
    $page_template = $item->intendedTemplate();
    $is_allergen = ($page_template == 'allergen');

    //  Allergen
    if ($is_allergen) {
      array_push($allergens, $item->title());

    //  Ingredient
    } else {
      $sub_allergens = $item->allergens()->toPages();

      foreach ($sub_allergens as $sub_item) {
        array_push($allergens, $sub_item->title());
      }
    }
  }

  //  Only show each allergen once
  $allergens = array_unique($allergens);

  //  Alphabetize
  sort($allergens);

  return $allergens;
}


/*
 * Dietary Preferences
 * Return whether a set of ingredients is vegetarian, vegan, or gluten free
 *
 * byron_get_dietary_preferences_from_ingredients(
 *   ingredients: $ingredients,
 * );
 *
 */

function byron_get_dietary_preferences_from_ingredients($ingredients = false) {
  //  Required arguments
  if (!$ingredients) return false;

  //  Assume these are true
  $results = [
    'vegetarian' => [
      'is_suitable' => true,
      'name' => 'Vegetarian',
      'abbreviation' => 'V',
      'text' => 'Suitable for vegetarians',
    ],
    'vegan' => [
      'is_suitable' => true,
      'name' => 'Vegan',
      'abbreviation' => 'Ve',
      'text' => 'Suitable for vegans',
    ],
    'gluten_free' => [
      'is_suitable' => true,
      'name' => 'Gluten Free',
      'abbreviation' => 'GF',
      'text' => 'Gluten free',
    ],
  ];

  //  If one ingredient is not one of these, make it false
  foreach ($ingredients as $ingredient) {
    $is_vegetarian = $ingredient->is_vegetarian()->toBool();
    $is_vegan = $ingredient->is_vegan()->toBool();
    $is_gluten_free = $ingredient->is_gluten_free()->toBool();

    if (!$is_vegetarian) {
      $results['vegetarian']['is_suitable'] = false;
    }

    if (!$is_vegan) {
      $results['vegan']['is_suitable'] = false;
    }

    if (!$is_gluten_free) {
      $results['gluten_free']['is_suitable'] = false;
    }
  }

  return $results;
}


/*
 * Get Location Map
 * Grabs a static map from the Mapbox API and stores it in cache
 *
 * byron_get_location_map($page)
 *
 */

function byron_get_location_map($newPage, $oldPage) {
  //  Check if the file already exists
  $has_map = $newPage->file('map.jpg');

  //  Check if the lat/lng have changed
  $old_coordinates = [$oldPage->address_lat()->value(), $oldPage->address_lng()->value()];
  $new_coordinates = [$newPage->address_lat()->value(), $newPage->address_lng()->value()];
  $coordinates_have_not_changed = $old_coordinates === $new_coordinates;

  $coordinates_are_empty = ($newPage->address_lat()->isEmpty() and $newPage->address_lng()->isEmpty());

  //  Quit early if this isn’t needed
  if (
    $coordinates_are_empty ||
    $has_map and $coordinates_have_not_changed) return true;

  //  Act as Kirby, just in case there is a permissions issue
  $kirby = kirby();
  $kirby->impersonate('kirby');

  //  Build the Mapbox API URL
  $api_key = $kirby->option('api_keys.mapbox');
  $username = 'byronburgers';
  $style_id = 'ckpo28fm30brv18o8b2yq6fam';
  $lat = $newPage->address_lat();
  $lng = $newPage->address_lng();
  $width = 1280; // this is the max
  $height = 914;
  $zoom_level = 16;

  $src = "https://api.mapbox.com/styles/v1/${username}/${style_id}/static/${lng},${lat},${zoom_level}/${width}x${height}@2x?fresh=true&logo=false&attribution=false&access_token=${api_key}";

  //  Create the alt text
  $title = $newPage->title();
  $uri = $newPage->uri();
  $alt = "Map of the local area around Byron ${title}";

  //  Wrap
  try {
    //  Get the returned file
    $mapbox_file = file_get_contents($src);

    //  Write it to this location’s directory
    $file = F::write($newPage->contentFileDirectory() . '/map.jpg', $mapbox_file);
    $text = F::write($newPage->contentFileDirectory() . '/map.jpg.txt', "Alt: ${alt}");

  } catch (Exception $e) {
    //  Log the error
    $log = date("F j, Y, g:i a") . PHP_EOL . 'Mapbox API, could not get map for ' . $title . '. Error: ' . $e . PHP_EOL . PHP_EOL;
    file_put_contents(kirby()->roots()->index() . '/debug.log', $log, FILE_APPEND);
  }
}

/*
 * Get Address from Location
 * Returns a nice Kirby object to work with
 *
 * $address = byron_get_address_from_location($page);
 *
 */

function byron_get_address_from_location($location) {
  $line_one = $location->address_line_one();
  $line_two = $location->address_line_two();
  $city = $location->address_city();
  $county = $location->address_county();
  $postcode = $location->address_postcode();
  $url = 'https://www.google.com/maps/search/?api=1&query=Byron,+';

  foreach ([$line_one, $line_two, $city, $county, $postcode] as $param) {
    if ($param->isNotEmpty()) {
      $url .= $param->escape('url') . ' ';
    }
  }

  return new Obj([
    'line_one' => $line_one,
    'line_two' => $line_two,
    'city' => $city,
    'county' => $county,
    'postcode' => $postcode,
    'url' => $url,
  ]);
}


/*
 * Get Coordinates from Query
 * Return geolocation coordinates from the Mapbox API for a given query
 *
 * byron_get_coordinates_from_query($query)
 *
 * See: https://docs.mapbox.com/api/search/geocoding/
 *
 */

function byron_get_coordinates_from_query($query) {
  //  Act as Kirby, just in case there is a permissions issue
  $kirby = kirby();
  $kirby->impersonate('kirby');

  //  Build the Mapbox API URL
  $api_key = $kirby->option('api_keys.mapbox');
  $username = 'byronburgers';

  //  There is a 20 search term limit for the API
  $query = byron_cap_string_at_word_count($query, 20);
  $query = Escape::url($query);

  //  The search query has a max length of 256 characters
  $query = Str::substr($query, 0, 255);

  $src = "https://api.mapbox.com/geocoding/v5/mapbox.places/${query}.json?autocomplete=false&country=gb&language=en&limit=1&types=postcode,place,locality,neighborhood,address&access_token=${api_key}";

  try {
    $response = file_get_contents($src);
    $json = json_decode($response, TRUE);

    return $json;

  } catch (Exception $e) {
    //  Log the error
    $log = date("F j, Y, g:i a") . PHP_EOL . 'Mapbox API, could not get coordinates for "' . $query . '". Error: ' . $e . PHP_EOL . PHP_EOL;
    file_put_contents(kirby()->roots()->index() . '/debug.log', $log, FILE_APPEND);

    return $e;
  }
}

/*
 * Cap a string at a wordcount
 * This is not a perfect solution, but should be good enough here
 *
 * byron_cap_string_at_word_count($string, 20);
 *
 * See: https://stackoverflow.com/questions/965235/how-can-i-truncate-a-string-to-the-first-20-words-in-php#answer-965290
 *
 */

function byron_cap_string_at_word_count($string, $word_count) {
  //  Assume that a space breaks up the words
  $words = explode(" ", $string);

  //  Get the first X of these
  $capped_words = array_slice($words, 0, $word_count);

  //  Add them back together again
  $result = implode(" ", $capped_words);

  return $result;
}

/*
 * Order locations by proximity to coordinates
 *
 * byron_order_locations_by_proximity_to_coordinates($locations, $coordinates);
 *
 * Both of these formula options are simple as they are just as the crow flies,
 * not how you might drive there. To do that, another API would be needed.
 *
 * See: https://www.intelliwolf.com/find-nearest-location-from-array-of-coordinates-php/
 * See: https://getkirby.com/docs/cookbook/content/sorting#custom-sorting
 *
 */

function byron_order_locations_by_proximity_to_coordinates($locations, $coordinates) {
  [$lng, $lat] = $coordinates;
  $earth_radius_in_miles = 3958.761;

  $locations->map(function ($item) use ($lat, $lng, $earth_radius_in_miles) {
    $item_lat = $item->address_lat()->or('-1')->value();
    $item_lng = $item->address_lng()->or('-1')->value();

    //  Pythagorean
    //  Simple, quickest, least accurate
    // $a = $lat - $item_lat;
    // $b = $lng - $item_lng;

    // $distance = sqrt(($a**2) + ($b**2));
    // $item->distance = $distance;

    //  Haversine
    //  More complicated, slower, takes into account curvature of the earth
    $lat1 = deg2rad($item_lat);
    $lon1 = deg2rad($item_lng);
    $lat2 = deg2rad($lat);
    $lon2 = deg2rad($lng);

    $delta_lat = $lat2 - $lat1;
    $delta_lng = $lon2 - $lon1;

    $hav_lat = (sin($delta_lat / 2))**2;
    $hav_lng = (sin($delta_lng / 2))**2;

    $distance = 2 * asin(sqrt($hav_lat + cos($lat1) * cos($lat2) * $hav_lng));
    $distance_in_miles = $earth_radius_in_miles * $distance;

    $item->distance = $distance_in_miles;

    return $item;
  });

  //  Return the locations sorted by their distance
  return $locations->sortBy('distance', 'asc');
}

/*
 * Get footer illustration fields
 *
 * byron_get_footer_illustration()
 *
 */

function byron_get_footer_illustration($page) {
  return new Obj([
    'illustration' => $page->footer_illustration()->toFile(),
    'type' => $page->footer_illustration_type()->or('scroll'),
  ]);
}


/*
 * Handle Club form submission
 *
 * byron_handle_club_form_submission()
 *
 * For API endpoint documentation, see: https://developers.airship.co.uk/basics/contacts/write-a-contact
 *
 */


/*

Each location (unit) in Airship has an associated ID. This becomes the
value in the location dropdown.

To get a list of these:

```php
$url = 'https://api.airship.co.uk/v1/account/units';
$options = [
  'headers' => [
    'Authorization: Bearer ' . $kirby->option('api_keys.airship'),
    'Content-Type: application/json',
  ],
  'data' => [
    'account_id' => 290,
  ],
];
$request = Remote::get($url, $options);

print_r($request->content());
```

*/

function byron_handle_club_form_submission($kirby) {
  $request = $kirby->request();
  $data = $request->data();
  $is_POST = $request->is('POST');

  //  If this is a GET request send back an empty object
  if (!$is_POST) return [];

  //  Validate the form
  //  See: https://getkirby.com/docs/reference/system/validators
  //  TODO: Should there be a timing honeypot here? Or will AirShip pull out the spam well?

  //  This is weak checking on DOB, as they could add 31st April, but Airship will return the error
  $rules = [
    'email' => ['required', 'email'],
    'first_name' => ['required'],
    'last_name' => ['required'],
    'dob_day' => ['required'],
    'dob_month' => ['required'],
    'dob_year' => ['required'],
    'mobile_number' => ['required'],
    'location' => ['required'],
    'consent' => ['required'],
  ];

  $messages = [
    'email' => 'Please enter a valid email address',
    'first_name' => 'Please enter your first name',
    'last_name' => 'Please enter your last name',
    'dob_day' => 'Please enter your date of birth',
    'dob_month' => 'Please enter your month of birth',
    'dob_year' => 'Please enter your year of birth',
    'mobile_number' => 'Please enter your mobile number',
    'location' => 'Please select your closest Byron',
    'consent' => 'Please give your consent to proceed',
  ];

  $is_invalid = invalid($data, $rules, $messages);
  if ($is_invalid) return [
    'errors' => $is_invalid,
    'data' => $data,
  ];

  //  These are from AirShip support
  $airship_account_id = 290;
  $airship_source_id = 30207;

  $submission_data = [
    'account_id' => $airship_account_id,
    'first_name' => $data['first_name'],
    'last_name' => $data['last_name'],
    'email' => $data['email'],
    'mobile_number' => $data['mobile_number'],
    //  DOB format is yyyy-mm-dd
    'dob' => "{$data['dob_year']}-{$data['dob_month']}-{$data['dob_day']}",
    'allow_email' => true,
    'source_id' => $airship_source_id,
    'units' => [
      [
        'id' => $data['location'],
        'groups'=> [
          [
            'name' => 'Web Sign Ups', // ? Is this right
          ],
        ]
      ],
    ],
  ];

  //  Try submitting the data to Airship
  try {
    $url = 'https://api.airship.co.uk/v1/contact';
    $options = [
      'headers' => [
        'Authorization: Bearer ' . $kirby->option('api_keys.airship'),
        'Content-Type: application/json',
      ],
      'method' => 'POST',
      'data' => json_encode($submission_data),
      'timeout' => 60, // the API is slow
    ];
    $request = Remote::request($url, $options);

    /*
    There could be a request that comes back here like:

    {
    "message": "The given data was invalid.",
    "errors": {
        "dob": [
            "validation.date_multi_format"
        ],
        "mobile_number": [
            "Mobile is not a valid national mobile number",
            "Mobile is not a valid international mobile number"
        ]
    }
    */

  //  Catch the error
  } catch (Exception $error) {
    //  Log the error for checking later
    //  TODO: Test that this works and that it isn’t accessible from the outside
    $log = date("F j, Y, g:i a") . PHP_EOL . 'Airship error: ' . Escape::html($error) . PHP_EOL . PHP_EOL;
    file_put_contents(kirby()->roots()->index() . '/debug.log', $log, FILE_APPEND);

    //  Return the error to the template
    return [
      'error' => 'Your submission could not be completed... Please try again later or contact your local Byron directly.',
    ];
  }

  //  Return the request. It is not necessarily success at this point because
  //  Airship could return errors
  return $request->json();
}


/*
 * Get Grouped Opening Hours
 *
 * byron_get_allergen_notice(
 *   intro: 'This product contains: ',
 *   ingredients: $ingredients,
 * );
 *
 * byron_get_allergen_notice(
 *   intro: 'During preparation, this product may have come into contact with :',
 *   allergens: $preparation_allergens,
 * ),
 *
 */

 function byron_get_grouped_opening_hours($opening_hours) {
   if (!isset($opening_hours) || $opening_hours->isEmpty()) return false;

  $grouped = [];

  //  Loop through initially to group similar days
  foreach ($opening_hours as $item) {
    $day = $item->day();
    $opening_time = $item->opening_time();
    $closing_time = $item->closing_time();

    //  All are required
    if ($day->isEmpty() or $opening_time->isEmpty() or $closing_time->isEmpty()) continue;

    //  Check whether this matches the last day
    $previous_index = (count($grouped) - 1);
    $previous = $grouped[$previous_index] ?? false;
    $matches_previous = (
      $previous and
      ($previous['opening_time'] == $opening_time) and
      ($previous['closing_time'] == $closing_time)
    );

    //  If it matches, merge
    if ($matches_previous) {
      array_push($grouped[$previous_index]['all_days'], $day);
      $grouped[$previous_index]['end_day'] = $day;

    //  Else add as unique item
    } else {
      array_push($grouped, [
        'start_day' => $day,
        'all_days' => [$day],
        'end_day' => false,
        'opening_time' => $opening_time,
        'closing_time' => $closing_time,
      ]);
    }
  }

  return $grouped;
}
