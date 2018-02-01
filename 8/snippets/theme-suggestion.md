# Ajout de thème pour le rendu twig

```php
<?php

/**
 * @file mytheme.theme
 * Override theming functions.
 */

use Drupal\block\Entity\Block;
use Drupal\block_content\Entity\BlockContent;
use Drupal\Core\Render\Element;

/**
 * Adding suggestion template for block hook.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_block_alter(array &$suggestions, array $variables) {
  $block = $variables['elements'];
  if(!empty($block['content']['#block_content']) && $block['content']['#block_content'] instanceof BlockContent) {
    $bundle = $block['content']['#block_content']->bundle();
    array_splice($suggestions, 2, 0, 'block__' . $bundle);
  }

  if (!empty($variables['elements']['#id'])) {
    $block = Block::load($variables['elements']['#id']);
    if ($block) {
      $settings = $block->get('settings');
      list($id) = explode(':', $settings['id']);
      if (!in_array('block__' . $id . '__' . $block->getRegion(), $suggestions)) {
        array_splice($suggestions, count($suggestions) - 1, 0, 'block__' . $id . '__' . $block->getRegion());
      }

      list($name) = explode('_', $variables['elements']['#id']);
      if (!in_array('block__' . $name . '__' . $block->getRegion(), $suggestions)) {
        $suggestions[] = 'block__' . $name . '__' . $block->getRegion();
      }
      else {
        $suggestions[] = 'block__' . $variables['elements']['#id'] . '__' . $block->getRegion();
      }
    }
  }
  elseif (isset($variables['elements']['#configuration']['region'])) {
    $suggestions[] = 'block__page_' . $variables['elements']['#configuration']['region'] . '__' . end(explode(':', $variables['elements']['#plugin_id']));
  }
}

/**
 * Adding suggestion template for field hook.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_field_alter(array &$suggestions, array $variables) {
  if (isset($variables['element']['#field_type'])
    && isset($variables['element']['#bundle'])
    && isset($variables['element']['#view_mode'])
  ) {
    $new = 'field__' . $variables['element']['#entity_type'] . '__' . $variables['element']['#field_name'] . '__' . $variables['element']['#bundle'] . '__' . $variables['element']['#view_mode'];
    if (!in_array($new, $suggestions)) {
      array_splice($suggestions, count($suggestions) + 1, 0, $new);
    }
  }
}

/**
 * Implements hook_theme_suggestions_hook_alter() for views_view template.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_views_view_alter(array &$suggestions, array $variables) {
  $new = 'views_view' . '__' . $variables['view']->id() . '__' . $variables['view']->current_display;
  if (!in_array($new, $suggestions)) {
    array_splice($suggestions, 1, 0, $new);
  }
}

/**
 * Implements hook_theme_suggestions_hook_alter() for container template.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_container_alter(array &$suggestions, array $variables) {
  if (isset($variables['element']['#type']) && $variables['element']['#type'] == 'view') {
    $new = 'container__' . $variables['element']['#type'] . '_' . $variables['element']['#name'] . '_' . $variables['element']['#display_id'];
    if (!in_array($new, $suggestions)) {
      array_splice($suggestions, 1, 0, $new);
    }
  }
}

/**
 * Implements hook_theme_suggestions_hook_alter() for form_element template.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_form_element_alter(array &$suggestions, array $variables) {
  if(isset($variables['element']['#type'])) {
    $new = $variables['theme_hook_original'] . '__' . $variables['element']['#type'];
    if (!in_array($new, $suggestions)) {
      array_splice($suggestions, count($suggestions) + 1, 0, $new);
    }
  }
}

/**
 * Implements hook_theme_suggestions_hook_alter() for fieldset template.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_fieldset_alter(array &$suggestions, array $variables) {
  if(isset($variables['element']['#type'])) {
    $new = $variables['theme_hook_original'] . '__' . $variables['element']['#type'];
    if (!in_array($new, $suggestions)) {
      array_splice($suggestions, count($suggestions) + 1, 0, $new);
    }
  }
}

/**
 * Implements hook_theme_suggestions_hook_alter() for entity_print template.
 *
 * @inheritdoc
 */
function mytheme_theme_suggestions_entity_print_alter(array &$suggestions, array $variables) {
  if(isset($_GET['type'])) {
    $new = $variables['theme_hook_original'] . '__' . $_GET['type'];
    if (!in_array($new, $suggestions)) {
      array_splice($suggestions, count($suggestions) + 1, 0, $new);
    }
  }
}
```
