# Retrieve a list of terms from a taxonomy

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
