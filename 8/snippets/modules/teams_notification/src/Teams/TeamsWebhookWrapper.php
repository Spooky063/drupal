<?php

declare(strict_types=1);

namespace Drupal\notify\Teams;

use Drupal\notify\Teams\AdaptiveCards\Contract\MessageRenderable;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Log\LoggerInterface;

final class TeamsWebhookWrapper
{
    public function __construct(
        private Client $client,
        private LoggerInterface $logger
    ) {
    }

    public function notify(MessageRenderable $message): void
    {
        try {
            $this->client->post('', [
                'json' => $message->render(),
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (RequestException $e) {
            $this->logger->error($e->getMessage());
        }
    }
}
