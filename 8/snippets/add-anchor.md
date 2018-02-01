# Ajout d'une ancre

## Vers une page spécifique

Ajout d'une ancre avec un **formulaire Webform** en sortie.  
On modifiera le texte pour l'affichage de ce lien avec un formatage particulier.

```php
<?php
/**
 * @file
 */
 
[...]

// Récupération d'un webform spécifique qui s'appelle contact_form
$webform = \Drupal::entityTypeManager()->getStorage('webform')->load('contact_form');

// Création de l'URL
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

// Création du lien
$link = \Drupal\Core\Link::fromTextAndUrl(
    \Drupal\Core\Render\Markup::create(
        '<span class="btn-text">'.$title.'
        <span class="visible-text">'.$title.'</span>
        <span class="hover-text">'.$title.'</span>'
    ),
    $url
);

// On l'insère dans le template
$variables['content'] = $link;

[...]
```

## Vers une page spécifique en mode modal

```php
<?php
/**
 * @file
 */
 
[...]

// Création de l'url
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

// Création du lien
$link = Drupal\Core\Link::fromTextAndUrl($this->t('Le titre de mon lien'), $url);

// On l'insère dans le template
$variables['content'] = $link;

[...]
```
