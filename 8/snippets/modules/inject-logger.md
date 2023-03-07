To inject a specific logger into a custom service your can:

1. Inject a specific logger into your service

```yml
# my_module.services.yml
logger.channel.mymodule:
  parent: logger.channel_base
  arguments: ['mymodule']

my_service:
  class: Drupal\my_module\MyService
  arguments: ['@logger.channel.mymodule']
 ```
 
2. Get your logger into your service

```php
use Psr\Log\LoggerInterface;

class MyService {

  public function __construct(
    private LoggerInterface $logger,
  ) {}
  
}
```
