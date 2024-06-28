<?php

declare(strict_types=1);

namespace Drupal\notification\Plugin\Notification\sms;

interface SmsInterface
{
    public function sendSms(string $recipient, string $message): void;
}
