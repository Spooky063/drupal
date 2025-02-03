<?php

declare(strict_types=1);

namespace Drupal\sse_notify;

use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Drupal\sse_notify\Event\NodeEvent;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

final class NodeEventService
{
    public const NODE_UPDATE_TOPIC = '/notification/node';

    public function __construct(
        private readonly HubInterface $hub,
        private readonly AccountInterface $account,
    ) {
    }

    public function nodeUpdate(NodeInterface $node): void
    {
        $event = new NodeEvent(
            [
            'type' => 'node',
            'action' => 'update',
            'id' => $node->id(),
            'data' => [
              'title' => $node->getTitle(),
              'type' => $node->getType(),
              'userId' => $this->account->id(),
              'username' => $this->account->getAccountName(),
            ]
            ]
        );

        $update = new Update(self::NODE_UPDATE_TOPIC, $event->jsonSerialize(), true);

        $this->hub->publish($update);
    }
}
