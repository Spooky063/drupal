To create a new breadcrumb class you must:

1. Create a new service with a specific tag

```yml
# my_module.services.yml
mymodule.breadcrumb: 
  class: Drupal\my_module\Breadcrumb\MyModuleBreadcrumbBuilder
  tags:
    - { name: breadcrumb_builder, priority: 1005 }
```

2. Implement the methods `applies` and `build`

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\Breadcrumb;

use Drupal\Core\Breadcrumb\Breadcrumb;
use Drupal\Core\Breadcrumb\BreadcrumbBuilderInterface;
use Drupal\Core\Routing\RouteMatchInterface;

final class MyModuleBreadcrumbBuilder implements BreadcrumbBuilderInterface
{
   public function applies(
        RouteMatchInterface $route_match
    ): bool {
      return true;
    }
    
    public function build(
        RouteMatchInterface $route_match,
    ): Breadcrumb {
      $breadcrumb = new Breadcrumb();
      
      // TODO
      // $breadcrumb->addLink(Link::createFromRoute($this->t('Home'), '<front>'));
      
      $breadcrumb->addCacheContexts(['route']);
      
      return $breadcrumb;
    }
}
```
