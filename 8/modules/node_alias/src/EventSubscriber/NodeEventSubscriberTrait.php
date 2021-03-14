<?php

declare(strict_types=1);

namespace Drupal\node_alias\EventSubscriber;

use Drupal\Core\Entity\EntityInterface;
use Drupal\node_alias\Entity\PathAlias;
use Drupal\node_alias\Event\NodeEvent;
use Drupal\node_alias\Event\NodeEvents;

trait NodeEventSubscriberTrait
{
    public static function getEvents(): array
    {
        $events = [];
        $events[NodeEvents::INSERT][] = ['onNodeEvent', 300];
        $events[NodeEvents::UPDATE][] = ['onNodeEvent', 300];
        $events[NodeEvents::DELETE][] = ['onNodeEvent', 300];

        return $events;
    }

    public function onNodeEvent(NodeEvent $event, $event_name): void
    {
        switch ($event_name) {
            case NodeEvents::INSERT:
                $this->onNodeEdit($event->getEntity(), $event->getPathAlias(), 'insert');
                break;

            case NodeEvents::UPDATE:
                $this->onNodeEdit($event->getEntity(), $event->getPathAlias(), 'update');
                break;

            case NodeEvents::DELETE:
                $this->onNodeDelete($event->getEntity(), $event->getPathAlias());
                break;
        }
    }

    public function onNodeEdit(EntityInterface $entity, PathAlias $pathAlias, string $op): void
    {
    }

    public function onNodeDelete(EntityInterface $entity, PathAlias $pathAlias): void
    {
    }
}
