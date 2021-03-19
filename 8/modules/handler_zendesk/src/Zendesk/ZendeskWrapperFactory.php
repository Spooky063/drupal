<?php

declare(strict_types=1);

namespace Drupal\handler_zendesk\Zendesk;

use Zendesk\API\HttpClient as ZendeskAPI;

class ZendeskWrapperFactory
{
    public static function create($config): ZendeskWrapper
    {
        $zendesk = $config->get('zendesk.settings');

        $client = new ZendeskAPI($zendesk->get('subdomain'));
        $client->setAuth('basic', [
            'username' => $zendesk->get('username'),
            'token'    => $zendesk->get('token')
        ]);

        return new ZendeskWrapper($client);
    }
}
