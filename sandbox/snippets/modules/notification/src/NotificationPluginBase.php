<?php

declare(strict_types=1);

namespace Drupal\notification;

use Drupal\Component\Plugin\PluginBase;

abstract class NotificationPluginBase extends PluginBase
{
    public function label(): string
    {
        return (string) $this->pluginDefinition['label'];
    }
}
