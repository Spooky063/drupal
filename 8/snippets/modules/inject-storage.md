To inject a specific storage into a custom service you must:

1. Inject a specific storage into your service (here the node storage)

```yml
# my_module.services.yml
node_storage: 
  class: Drupal\node\NodeStorage
  factory: entity_type.manager:getStorage
  arguments: ['node']

my_service:
  class: Drupal\my_module\MyService
  arguments: ['@node_storage']
 ```
 
2. Get your storage into your service

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module;

use Drupal\node\NodeStorageInterface;

final class MyService {

  public function __construct(
    private NodeStorageInterface $storage,
  ) {}
  
}
```
