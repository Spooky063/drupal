# Adding icon into link

We want to add an HTML element to the anchor to display an icon instead of text.

```php
function mytheme_preprocess_field(&$variables) {
    $element = $variables['element'];

    if ($element['#field_name'] === 'field_social_link') {
        foreach ($variables['items'] as $key => $item) {
            // Add icon
            $icon  = '<i class="icon-'.strtolower($item['content']['#title']).'"></i>';
            $title = \Drupal\Core\Render\Markup::create($icon);
            $variables['items'][$key]['content']['#title'] = $title;

            // Add title attribute
            $variables['items'][$key]['content']['#options']['attributes'] = [
                'title' => $item['content']['#title']
            ];
        }
    }
}
```
