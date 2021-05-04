<?php

/**
 * @file
 * Lists available colors and color schemes for the Bartik theme.
 */

$info = [
  // Available colors and color labels used in theme.
  'fields' => [
    'primary' => t('Primary color'),
  ],

  'schemes' => [
    'default' => [
      'title' => t('Default'),
      'colors' => [
        'primary' => '#2981da'
      ],
    ],
  ],

  // CSS files (excluding @import) to rewrite with new color scheme.
  'css' => [
    'css/colors.css',
  ],

  // Files to copy.
  'copy' => [
    'logo.svg',
  ],

  'gradients' => [
  ],

  // Preview files.
  'preview_library' => 'theme/color.preview',
  //'preview_html' => 'color/preview.html',

  // Attachments is not mandatory
  '#attached' => [
    'drupalSettings' => [
      'color' => [
        // Put the logo path into JavaScript for the live preview.
        'logo' => theme_get_setting('logo.url', 'theme'),
      ],
    ],
  ],
];

