<?php

declare(strict_types=1);

namespace Drupal\notification\Plugin\Notification;

use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\notification\Attribute\Notification;
use Drupal\notification\NotificationInterface;
use Drupal\notification\NotificationPluginBase;

#[Notification(
    id: "push_notification",
    label: new TranslatableMarkup("Push Notification"),
    description: new TranslatableMarkup("Sending an push notification."),
)]
class PushNotification extends NotificationPluginBase implements NotificationInterface
{
    public function sendNotification(array $recipients, string $message): void
    {
      // TODO: Put your logic here
    }
}
