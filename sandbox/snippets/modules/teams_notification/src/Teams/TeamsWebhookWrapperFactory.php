<?php

declare(strict_types=1);

namespace Drupal\notify\Teams;

use GuzzleHttp\Client;

final class TeamsWebhookWrapperFactory
{
    public static function create(): Client
    {
        $config = [
            'base_uri' => 'PUT THE HOOK URL',
        ];

        $client = new Client($config);

        return $client;
    }
}
