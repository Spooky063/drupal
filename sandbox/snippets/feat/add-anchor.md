# Add anchor

## To a specific page

Add an anchor with a **Webform** as output.  
We'll modify the text to display this link with special formatting.

```php
$webform = \Drupal::entityTypeManager()->getStorage('webform')->load('contact_form');

$url = $webform->toUrl('canonical', [
    // prefill if option 'Allow elements to be populated using query string parameters'
    // is checked into contact_form webform parameters
    'query' => [
        'email' => 'email@domain.com'
    ],
    // adding specific class
    'attributes' => [
        'class' => [
            'btn',
            'btn-primary'
        ]
    ],
]);

$link = \Drupal\Core\Link::fromTextAndUrl(
    \Drupal\Core\Render\Markup::create(
        '<span class="btn-text">'.$title.'
        <span class="visible-text">'.$title.'</span>
        <span class="hover-text">'.$title.'</span>'
    ),
    $url
);

$variables['content'] = $link;
```

## To a specific page on modal way

```php
$options = [
  'attributes' => [
        'data-dialog-type' => 'modal',
        'data-dialog-options' => \Drupal\Component\Serialization\Json::encode([
            'width' => 800,
        ]),
        'class' => [
            'use-ajax',
            'btn',
            'btn-primary'
        ],
    ],
];
$url = Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => 2], $options);

$link = Drupal\Core\Link::fromTextAndUrl($this->t('Le titre de mon lien'), $url);

$variables['content'] = $link;
```
