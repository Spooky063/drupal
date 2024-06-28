<?php

declare(strict_types=1);

namespace Drupal\notification\Plugin\Notification\sms\Twilio;

use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;

class TwilioWrapperFactory
{
    /**
     * @param array<array-key, string> $credentials
     * @throws ConfigurationException
     */
    public static function create(array $credentials): TwilioWrapper
    {
        try {
            $client = new Client($credentials['twilio_account_sid'], $credentials['twilio_auth_token']);
        } catch (ConfigurationException $configurationException) {
            throw new ConfigurationException($configurationException->getMessage());
        }

        return new TwilioWrapper($client);
    }
}
