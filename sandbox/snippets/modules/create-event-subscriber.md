To create a new event subscriber class you must:

1. Create a new service with a specific tag

```yml
# my_module.services.yml
mymodule.subscriber: 
  class: Drupal\my_module\EventSubscriber\MyModuleSubscriber
  tags:
    - { name: event_subscriber }
 ```
 
2. Implement the method `getSubscribedEvents`

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class MyModuleSubscriber implements EventSubscriberInterface {

  public static function getSubscribedEvents(): array
  {}
  
}
```
