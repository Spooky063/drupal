<?php

declare(strict_types=1);

namespace Drupal\notification;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\notification\Attribute\Notification;

final class NotificationPluginManager extends DefaultPluginManager
{
    public function __construct(
        \Traversable $namespaces,
        CacheBackendInterface $cache_backend,
        ModuleHandlerInterface $module_handler,
    ) {
        parent::__construct(
            'Plugin/Notification',
            $namespaces,
            $module_handler,
            NotificationInterface::class,
            Notification::class,
        );
        $this->alterInfo('notification_info');
        $this->setCacheBackend($cache_backend, 'notification_plugins');
    }
}
