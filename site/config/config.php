<?php

return [
  //  Debug
  'debug' => false,

  //  Homepage
  'home' => 'home',

  //  Routes
  'routes' => [
    //  Redirect /sitemap to the proper XML route for the sitemapper plugin
    [
      'pattern' => 'sitemap',
      'action'  => function() {
        return go('sitemap.xml', 301);
      }
    ],
    //  Clear the cache
    //  This route is not protected, but the random string added to the end
    //  adds obscurity so it is unlikely to be found.
    [
      'pattern' => '/clear-page-cache-pNrnf7ixLW8q9RKk',
      'action' => function () {
        kirby()->cache('pages')->flush();
        return 'SUCCESS';
      }
    ],

    //  Misc redirects from old Squarespace site
    [
      'pattern' => ['/chelmsford', '/manchesterpat', '/southampton', '/wembley'],
      'action' => function () {
        return go('/order', 301);
      }
    ],
    [
      'pattern' => 'byron-blog',
      'action' => function () {
        return go('/', 301);
      }
    ],
    [
      'pattern' => 'termsandconditions',
      'action' => function () {
        return go('/terms-and-conditions', 301);
      }
    ],
    [
      'pattern' => 'byronclub',
      'action' => function () {
        return go('/byron-club', 301);
      }
    ],
  ],

  //  Hooks
  'hooks' => [
    'page.create:after' => function ($page) {
      $page_template = $page->intendedTemplate();

      //  Auto-publish some template types by default — there is no need for
      //  draft statuses with these
      //  See: https://forum.getkirby.com/t/default-status-to-listed/14648/4
      if (
        $page_template == 'allergen' ||
        $page_template == 'ingredient' ||
        $page_template == 'stories' ||
        $page_template == 'story' ||
        $page_template == 'redirect'
      ) {
        $page->publish();
      }
    },
    'page.update:after' => function ($newPage, $oldPage) {
      $page_template = $newPage->intendedTemplate();

      //  Grab the map image from the Mapbox API
      if ($page_template == 'location') {
        byron_get_location_map($newPage, $oldPage);
      }
    },

    //  Assign files with the blueprint specific to their type
    //  See: https://forum.getkirby.com/t/is-it-possible-to-get-the-file-type-in-blueprint/17683/8
    'file.create:after' => function ($file) {
      $type = $file->type();

      //  Don’t interfere on stories where files have their own template
      //  Check that the page exists incase this runs on $site
      $template = $file->page() ? $file->page()->intendedTemplate() : '';
      if ($template == 'story') return;

      if ($type == 'image') {
        $file->update(['template' => 'image']);
      } elseif ($type == 'audio') {
        $file->update(['template' => 'audio']);
      } elseif ($type == 'video') {
        $file->update(['template' => 'video']);
      }
    },
  ],

  //  Cache
  //  See: https://getkirby.com/docs/guide/cache
  'cache' => [
    'pages' => [
      'active' => true,

      //  Pages to ignore
      'ignore' => ['locations'],
    ]
  ],

  //  API Keys
  //  E.g. $kirby->option('api_keys.mapbox')
  'api_keys' => [
    'mapbox' => 'pk.eyJ1IjoiYnlyb25idXJnZXJzIiwiYSI6ImNrcG54dG9kYzAya20yd3F4b2k0eGMxbjAifQ.R3ez2qNP8h1E2B8F_8V1Xg',
    'airship' => 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZGY4ZmM2OWY5MTcxYWEzMjk2MDhkYjQxNTVlY2RiM2IxZDhmZTYwMDhiNTU0OGVlM2NiZjJiOTc1Yjg0MDYyMzc2ZGI1NzllY2YzMGMzZTciLCJpYXQiOjE2MjQ5NjQxNTMsIm5iZiI6MTYyNDk2NDE1MywiZXhwIjo0NzgwNjM3NTUwLCJzdWIiOiIxNiIsInNjb3BlcyI6WyJyZWFkIiwid3JpdGUiXX0.TDVhg8Met9laKD7dxZCSroD2ZtK2BUoyzlVddLiPpf6H_l4rKZxZYrda8lWdrcjQLAqsSpJ5zYXCICnU6v4hRHtDO0KzIyWj96gsVjHaDEA2tRIYCaRLvaNfzwM_vcfnwo-5bf-TkbcgAqGh42433K1B8aGyeZ3aTR8_98b52RSTjvTr5j6cWkJaMvHltX45egDnhAysh3jNy8Z9g-QMSSMYWXiCcxp2qBEZyCkXa0TlOAxrhjJcac8t-A8QNPylzKqU_Yx4N4F4URL8f8XOBhEK5ts9KPjOexc5RevyvuxXkyGpWFUpcLAiQPy3RksqJORF9YfPFIHkWc0Ttg16OhhLFuvB98OngmyFla_A6uleQELk4VaSrWXZDK5EtPxT8bYiB0KI9aiZkMQrzw_8_onAq_Zsp1W6ShB1fFSeDtSqHQdV68aWfrNaY9Mo6YAq9oWGrZ_6VPVp14KyrBQE6IHs6ry2mtxadvboE6IpW_O1JQk1cTTK9y_j0cq9LK0Qb46pz7WKp7grksfqFNfk-5ObSuBgRrY3RZMOTHGwU1AiNuYg-Cdy5aPqzlsRnemrifnLjorXnAthU8nOycqbVJ4M9K5ryAkr55Y4taoPv0BG_Ob_6RIUVLIrEX8GS-uHAdc-GIomaHkLaIsv94gs5O5dX4vWmynyWDH3hRVDnyE',
  ],

  //
  //  Thumbs
  //  Store srcsets

  'thumbs' => [
    //  E.g. <img srcset="<?= $image->srcset('Default'); />
    'srcsets' => [
      'Default' => [
        '320w' => ['width' => 320, 'quality' => 80],
        '540w' => ['width' => 540, 'quality' => 80],
        '1080w' => ['width' => 1080, 'quality' => 80],
        '2160w' => ['width' => 2160, 'quality' => 80],
      ],
    ]
  ],

  //
  //  Sitemap
  //  See: https://gitlab.com/kirbyzone/sitemapper/-/wikis/Configuration/Extra-Filtering-Function

  'cre8ivclick.sitemapper.pageFilter' => function($page) {
    $page_template = $page->intendedTemplate();

    //  Don’t show some pages
    if (
      $page_template == 'allergen' ||
      $page_template == 'blog' ||
      $page_template == 'ingredient' ||
      $page_template == 'menu_category' ||
      $page_template == 'stories' ||
      $page_template == 'story' ||
      $page_template == 'redirect'
    ) return false;

    if (
      $page_template == 'location' &&
      ($page->delivery_only()->toBool(false) === true)
    ) return false;

    return true;
  },


  //
  //  SEO
  //  See: https://github.com/pedroborges/kirby-meta-tags
  //  The plugin already escapes the strings

  //  TODO: Test the open graph data on Facebook and Twitter

  //  Site Defaults
  'pedroborges.meta-tags.default' => function ($page, $site) {
    $title = $page->isHomepage() ? $site->title() : $page->title() . ' | ' . $site->title();
    $description = $page->meta_description()->isNotEmpty() ? $page->meta_description() : $site->meta_description();

    $page_image = $page->meta_image()->toFile();
    $site_image = $site->meta_image()->toFile();

    $image = $page_image ?: $site_image;

    $twitter = $site->twitter();
    $instagram = $site->instagram();
    $facebook = $site->facebook();

    return [
      'title' => $title,
      'meta' => [
        'description' => $description
      ],
      'link' => [
        'canonical' => $page->url()
      ],
      'og' => [
        'title' => $title,
        'description' => $description,
        'type' => 'website',
        'site_name' => $site->title(),
        'url' => $page->url(),
        'locale' => 'en_GB',
        'namespace:image' => function() use ($image) {
          if ($image) {
            return [
              'image' => $image->url(),
              'height' => $image->height(),
              'width' => $image->width(),
              'type' => $image->mime()
            ];
          }
        }
      ],
      'twitter' => [
        'card' => 'summary',
        'site' => $twitter,
      ],
      'json-ld' => [
        'Organization' => [
          'name' => 'Byron',
          'url' => $site->url(),
          'logo' => kirby()->url('assets') . '/img/vector/logo.svg',
          'sameAs' => [
            $twitter->isNotEmpty() ? ('https://twitter.com/' . $twitter->value()) : '',$instagram->isNotEmpty() ? $instagram->value() : '',
            $facebook->isNotEmpty() ? $facebook->value() : '',
          ],
        ],
      ]
    ];
  },

  //  Template Specific
  'pedroborges.meta-tags.templates' => function ($page, $site) {
    return [
      //  See: https://jsonld.com/local-business/
      'location' => [
        'json-ld' => [
          'Restaurant' => function ($page) {
            $title = $page->title();
            $gallery = $page->gallery()->toFiles();
            $gallery_urls = $gallery->isNotEmpty() ? $gallery->map(function ($item) {
              return $item->url();
            })->values() : false;
            $address = byron_get_address_from_location($page);
            $street_address = false;

            if ($address->line_one()->isNotEmpty()) {
              $street_address = $address->line_one()->value();
            }

            if ($address->line_two()->isNotEmpty()) {
              $street_address .= ', ' . $address->line_two()->value();
            }

            $lat = $page->address_lat()->isNotEmpty() ? $page->address_lat()->value() : '';
            $lng = $page->address_lng()->isNotEmpty() ? $page->address_lng()->value() : '';

            $opening_hours = $page->opening_hours()->toStructure();
            $grouped_opening_hours = byron_get_grouped_opening_hours($opening_hours);
            $openingHoursSpecification = [];

            foreach ($grouped_opening_hours as $item) {
              $start_day = $item['start_day'];
              $all_days = $item['all_days'];
              $end_day = $item['end_day'];
              $opening_time = $item['opening_time'];
              $closing_time = $item['closing_time'];

              //  Most are required
              if ($start_day->isEmpty() or $opening_time->isEmpty() or $closing_time->isEmpty()) continue;

              array_push($openingHoursSpecification, [
                '@type' => 'OpeningHoursSpecification',
                'dayOfWeek' => array_map(function ($day) {
                  return $day->value();
                }, $all_days),
                'opens' => $opening_time->value(),
                'closes' => $closing_time->value(),
              ]);
            }

            return [
              'name' => 'Byron ' . $title->escape('html'),
              'image' => $gallery_urls,
              '@id' => $page->url(),
              'url' => $page->url(),
              'address' => [
                "@type" => "PostalAddress",
                "streetAddress" => $street_address,
                "addressLocality" => $address->city()->isNotEmpty() ? $address->city()->value() : '',
                "addressRegion" => $address->county()->isNotEmpty() ? $address->county()->value() : '',
                "postalCode" => $address->postcode()->isNotEmpty() ? $address->postcode()->value() : '',
                "addressCountry" => 'UK',
              ],
              'geo' => [
                "@type" => "GeoCoordinates",
                "latitude" => $lat,
                "longitude" => $lng,
              ],
              'telephone' => $page->phone()->isNotEmpty() ? $page->phone()->value() : '',
              'menu' => 'https://www.byron.co.uk/menu',
              'acceptsReservations' => "True",
              'openingHoursSpecification' => $openingHoursSpecification,
            ];
          },
        ],
      ],

      //  No index pages
      'error' => [
        'meta' => [
          'robots' => 'noindex',
        ],
      ],
    ];
  },
];
