To create a new access checker class you must:

1. Create a new service with a specific tag

```yml
# my_module.services.yml
mymodule.access_checker:
  class: Drupal\my_module\Access\MyModuleAccessCheck
  tags:
    - { name: access_check, applies_to: _mymodule_access_check }
```

For the example I create a new controller with the new restriction `_mymodule_access_check`

```php
# my_module.routing.yml
mymodule.controller:
  path: "/test"
  defaults:
    _controller: "\Drupal\my_module\Controller\MyModuleController::index"
    _title: "My example to implement custom access check"
  methods: [GET]
  requirements:
    _mymodule_access_check: 'TRUE'
```

2. Implement the method `access`

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;

final class MyModuleAccessCheck implements AccessInterface
{
  /**
   * {@inheritdoc}
   */
  public function access(
    Route $route, 
    RouteMatchInterface $route_match, 
    AccountInterface $account,
   ) {
    return AccessResult::neutral();
   }
}
```
