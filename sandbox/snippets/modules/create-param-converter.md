To create a new param converter class you must:

1. Create a new service with a specific tag

```yml
# my_module.services.yml
mymodule.param_converter: 
  class: Drupal\my_module\Routing\MyModuleConverter
  tags:
    - { name: paramconverter }
 ```
 
2. Implement the methods `convert` and `applies`

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\Routing;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;

final class MyModuleConverter implements ParamConverterInterface {

  /**
   * {@inheritdoc}
   */
  public static function convert(
    $value, 
    $definition, 
    $name, 
    array $defaults,
  ) {}
  
  /**
   * {@inheritdoc}
   */
  public function applies(
    $definition, 
    $name, 
    Route $route,
  ) {}
  
}
```
