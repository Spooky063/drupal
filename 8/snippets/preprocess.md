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
