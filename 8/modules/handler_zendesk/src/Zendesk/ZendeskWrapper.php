<?php

declare(strict_types=1);

namespace Drupal\handler_zendesk\Zendesk;

use Drupal\handler_zendesk\Entity\Contact;
use Zendesk\API\HttpClient;

class ZendeskWrapper implements ZendeskWrapperInterface
{
    private HttpClient $client;

    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function create(Contact $contact): void
    {
        $this->client->tickets()->create([
            'subject' => $contact->subject,
            'comment' => [
                'body' => $contact->message
            ],
            'requester' => [
                'name'  => $contact->name,
                'email' => $contact->email
            ],
            'priority' => 'normal'
        ]);
    }
}
