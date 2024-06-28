<?php

declare(strict_types=1);

namespace Drupal\notification\Plugin\Notification\sms\Twilio;

use Drupal\notification\Plugin\Notification\sms\SmsInterface;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class TwilioWrapper implements SmsInterface
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    public function sendSms(string $recipient, string $message): void
    {
        try {
            $this->client->messages->create($recipient, ['from' => '', 'body' => $message]);
        } catch (TwilioException $twilioException) {
            throw new TwilioException($twilioException->getMessage());
        }
    }
}
