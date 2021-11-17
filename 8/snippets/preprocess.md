# Preprocess

1. Add classes to all entities

```php
function THEME_preprocess_block(array &$variables): void
{
  $pluginId = $variables['plugin_id'];
  if ($pluginId === 'system_main_block') {
    $variables['attributes']['class'][] = _setClassesFromUrlArguments();
  }
}

function THEME_preprocess_field(array &$variables): void
{
  $element = $variables['element'];

  if (in_array($element['#field_type'], ['entity_reference', 'entity_reference_revisions'])) {
    foreach ($variables['items'] as &$item) {
      $item['attributes']->addClass(substr($element['#field_name'], 6));
    }
  }
  
  if (isset($variables['attributes'])) {
    $classes = isset($variables['attributes']['class']) ? $variables['attributes']['class'] : null;
    unset($variables['attributes']['class']);

    $prefix = '';
    if (
      in_array($element['#field_type'], ['entity_reference', 'entity_reference_revisions']) &&
      $element['#is_multiple'] === true
    ) {
      $prefix = 'grouped--';
    }

    if (is_array($classes)) {
      $variables['attributes']['class'][] = $prefix . substr($element['#field_name'], 6);
    } else {
      $variables['attributes']['class'][] = $classes;
      $variables['attributes']['class'][] = $prefix . substr($element['#field_name'], 6);
    }
  }
  
  if (in_array($element['#field_name'], ['field_button', 'field_button_label'])) {
    foreach ($variables['items'] as &$item) {
      $item['content']['#options']['attributes']['class'][] = 'btn';
    }
  }
}

function THEME_preprocess_node(array &$variables): void
{
  $node = $variables['node'];
  $variables['attributes']['class'][] = 'node--type--' . $node->bundle();
  $variables['attributes']['class'][] = 'node--view-mode--' . $variables['view_mode'];
}

function THEME_preprocess_page(array &$variables): void
{
  $variables['attributes']['class'][] = _setClassesFromUrlArguments('container--');
}

function THEME_preprocess_html(array &$variables): void
{
  $variables['attributes']['class'][] = _setClassesFromUrlArguments('page--');
}

function _setClassesFromUrlArguments(string $prefix = ''): array
{
  $classes = [];
  $pathArgs = _getUrlArguments();
  foreach ($pathArgs as $arg) {
    if ((int)$arg === 0 && strlen($arg) > 2) {
      $classes[] = $prefix . $arg;
    }
  }
  return $classes;
}

function _getUrlArguments(): array
{
  $currentPath = substr(\Drupal::service('path.current')->getPath(), 1);
  return explode('/', $currentPath);
}
```

Change the `field` template

```twig
{%
  set title_classes = [
    label_display == 'visually_hidden' ? 'visually-hidden',
  ]
%}
{%
  set name = field_name|slice(6)
  set prefix = "grouped--"
%}

{% if label_hidden %}
  {% if multiple %}
    <div class="{{ prefix }}{{ name }}__items">
      {% for item in items %}
        <div{{ item.attributes }}>{{ item.content }}</div>
      {% endfor %}
    </div>
  {% else %}
    {% for item in items %}
      {{ item.content }}
    {% endfor %}
  {% endif %}
{% else %}
  <div{{ attributes.addClass(name) }}>
    <h2{{ title_attributes.addClass(title_classes) }}>{{ label }}</h2>
    <div class="{{ prefix }}{{ name }}__items">
    {% for item in items %}
      <div{{ item.attributes }}>{{ item.content }}</div>
    {% endfor %}
    </div>
  </div>
{% endif %}

```

Be careful to add the attributes in the template

```twig
<div{{ attributes }}>
[...]
</div>
```

2. Add logo to all templates

```php
function THEME_preprocess(array &$variables): void
{
  $themeName = \Drupal::config('system.theme')->get('default');
  $variables['logo_path'] = theme_get_setting('logo.url', $themeName);
}
```
