To create a new cache context class you must:

1. Create a new service with a specific tag

```yml
# my_module.services.yml
cache_context.mymodule:
  class: Drupal\my_module\CacheContext\MyModuleCacheContext
  tags:
      - { name: cache_context }
 ```
 
Here you have create a new ID `mymodule` because the ID of the context is after the `cache_context` word.
 
For the example I create a new controller

```yml
# my_module.routing.yml
mymodule.controller:
  path: "/test"
  defaults:
    _controller: "\Drupal\my_module\Controller\MyModuleController::index"
    _title: "My example to implement cache context"
  methods: [GET]
  requirements:
    _permission: "access content"
 ```
 
2. Implement the method `getLabel`, `getContext` and `getCacheableMetadata`

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\CacheContext;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Cache\Context\CacheContextInterface;

final class MyModuleCacheContext implements CacheContextInterface
{
  /**
   * {@inheritdoc}
   */
  public static function getLabel()
  {
    return t('My module');
  }
  
  /**
   * {@inheritdoc}
   */
  public function getContext() {
  }
  
  /**
   * {@inheritdoc}
   */
  public function getCacheableMetadata()
  {
    return new CacheableMetadata();
  }
}
```

3. Use the new context cache create with the ID.

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\Controller;

use Drupal\Core\Controller\ControllerBase;

final class MyModuleController extends ControllerBase
{
  public function index(): array
  {
    return [
      "#markup" => $this->t("This is an example"),
      "#cache" => [
        "contexts" => [
          "mymodule" // ID of the context
        ]
      ]
    ];
  }
}
```

<p><small>Source: https://www.innoraft.com/blogs/drupal-8-cache-context-efficient-way-context-based-caching</small></p>
