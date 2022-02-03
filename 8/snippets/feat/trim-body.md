# Trim body with max length

If you want to display text with specific length administer on BO.

```php
use Drupal\Component\Utility\Unicode;
use Drupal\Core\Entity\Entity\EntityViewDisplay;

function mytheme_preprocess_field(array &$variables): void
{
  $element = $variables['element'];
  $items = $variables['items'];
  
  if ($element['#field_name'] === 'body' && $variables['entity_type'] === 'node' && $variables['field_type'] === 'text_with_summary') {
    foreach ($items as &$item) {
      if ($variables['element']['#formatter'] === "text_summary_or_trimmed") {
        $storage = \Drupal::entityTypeManager()->getStorage('entity_view_display');
        /** @var EntityViewDisplay $view_display */
        $view_display = $storage->load('node.'  . $element['#bundle'] . '.' . $element['#view_mode']);
        
        $body_display = $view_display->getComponent('body');
        $trim_settings = $body_display['settings']['trim_length'];
        
        $text = strip_tags($item['content']['#text']);
        $item['content']['#text'] = '<p>' . Unicode::truncate($text, $trim_settings, false, true) . '</p>';
      }
    }
  }
}
```
