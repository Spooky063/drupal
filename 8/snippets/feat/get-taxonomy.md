# Récupération d'une liste de terme d'un taxonomie

Permet de retourner une liste de taxonomie d'un vocabulaire spécifique.
On récupère les valeurs traduite selon la langue sur laquelle l'utilisateur se trouve.

```php
// Get language code for translation
$langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();

// Get all terms of specific vocabulary
$terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($vid);
$terms_values[] = array_map(
    function($term) use ($langcode) {
        $term_trans = \Drupal::service('entity.repository')->getTranslationFromContext($term, $langcode);
        return [$term_trans->tid->value => $term_trans->name->value];
    },
    $terms
);
```
