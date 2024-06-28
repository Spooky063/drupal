<?php

declare(strict_types=1);

namespace Drupal\notification;

interface NotificationInterface
{
    /**
     * @param array<array-key, string> $recipients
     */
    public function sendNotification(array $recipients, string $message): void;
}
