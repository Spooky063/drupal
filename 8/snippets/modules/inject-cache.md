To inject a new cache bin into a custom service you must:

1. Inject a new cache bin into your service

```yml
# my_module.services.yml
cache.mymodule:
  class: Drupal\Core\Cache\CacheBackendInterface
  tags:
    - { name: cache.bin }
  factory: ['@cache_factory', 'get']
  arguments: ['mymodule']

my_service:
  class: Drupal\my_module\MyService
  arguments: ['@cache.mymodule']
 ```
 
2. Get your logger into your service

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module;

use Drupal\Core\Cache\DatabaseBackend;

final class MyService {

  public function __construct(
    private DatabaseBackend $cache,
  ) {}
  
}
```

To check if the new cache is created, you can run this command and see if you see the new key:

```
drush cc bin
```
