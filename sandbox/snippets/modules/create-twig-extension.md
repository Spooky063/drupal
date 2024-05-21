To create a new twig extension filter of function you must:

1. Create a new service with a specific tag

```yml
# my_module.services.yml
twig_extension.mymodule: # twig_extension.NAME_OF_TWIG_EXTENSION
  class: Drupal\my_module\TwigExtension\MyModuleTwigExtension
  tags:
    - { name: twig.extension }
```

2. Implement the logic

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\TwigExtension;

use Twig\Extension\AbstractExtension;

final class MyModuleTwigExtension extends AbstractExtension
{
  /**
   * {@inheritdoc}
   */
  public function getName()
  {
    return 'mymodule.mymodule.twig_extension'; // mymodule.NAME_OF_TWIG_EXTENSION.twig_extension
  }
  
  // If new filter
  public function getFilters()
  {
    return [
      new \Twig\TwigFilter('NAME', [$this, 'FUNCTION_NAME']),
    ];
  }
  
  // If new function
  public function getFunctions()
  {
    return [
      new \Twig\TwigFunction('NAME', [$this, 'FUNCTION_NAME']),
    ];
  }
}
```
