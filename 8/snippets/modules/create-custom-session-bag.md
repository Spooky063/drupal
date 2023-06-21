The Drupal way to pass data via session is to use the service `tempstore.private` but there is an other way.

1. Create a new service with a specific tag

```yml
# my_module.services.yml
mymodule.session_bag:
  class: Drupal\my_module\Session\MyModuleSessionBag
  tags:
    - { name: session_bag }
 ```

2. Create an interface

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\Session;

interface MyModuleBagInterface extends SessionBagInterface
{
  public function add(string $type, mixed $message): void;

  public function set(string $type, string|array $messages): void;

  public function peek(string $type, array $default = []): array;

  public function peekAll(): array;

  public function get(string $type, array $default = []): array;

  public function all(): array;

  public function setAll(array $messages): void;

  public function has(string $type): bool;

  public function keys(): array;
}
```

3. Create a class

```php
<?php

declare(strict_types=1);

namespace Drupal\my_module\Session;

final class MyModuleSessionBag extends MyModuleBagInterface
{
  private string $name = 'mymodule';
  private array $datas = [];
  private string $storageKey;

  public function __construct(string $storageKey = '_drupal_mymodule')
  {
    $this->storageKey = $storageKey;
  }

  public function getName() {
    return $this->name;
  }

  public function setName(string $name)
  {
    $this->name = $name;
  }

  public function initialize(array &$datas) {
    $this->datas = &$datas;
  }

  public function add(string $type, mixed $message)
  {
    $this->datas[$type][] = $message;
  }

  public function peek(string $type, array $default = []): array
  {
    return $this->has($type) ? $this->datas[$type] : $default;
  }

  public function peekAll(): array
  {
    return $this->datas;
  }

  public function get(string $type, array $default = []): array
  {
    if (!$this->has($type)) {
      return $default;
    }

    $return = $this->datas[$type];

    unset($this->datas[$type]);

    return $return;
  }

  public function all(): array
  {
    $return = $this->peekAll();
    $this->datas = [];

    return $return;
  }

  public function set(string $type, string|array $messages)
  {
    $this->datas[$type] = (array) $messages;
  }

  public function setAll(array $messages)
  {
    $this->datas = $messages;
  }

  public function has(string $type): bool
  {
    return \array_key_exists($type, $this->datas) && $this->datas[$type];
  }

  public function keys(): array
  {
    return array_keys($this->datas);
  }

  public function getStorageKey() {
    return $this->storageKey;
  }

  public function clear() {
    return $this->all();
  }
}
```

4. How to use it

First, to add some data inside the new bag:

```php
  /** @var MyModuleSessionBag $sessionBag */
  $sessionBag = \Drupal::service('mymodule.session_bag');
  $sessionBag->add('event', 'This is an example.');
```

And if you want to get the data, you can use the name of the session bag:

```php
  $session = \Drupal::request()->getSession();
  $datas = $session->getBag('mymodule')->clear();
```