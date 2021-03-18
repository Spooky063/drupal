<?php

declare(strict_types=1);

namespace Drupal\entity_alias\EventSubscriber;

use Drupal\entity_alias\Event\EntityEvent;
use Drupal\entity_alias\Event\EntityEvents;

trait EntityEventSubscriberTrait
{
    public static function getEvents(): array
    {
        $events = [];
        $events[EntityEvents::INSERT][] = ['onEntityEvent', 300];
        $events[EntityEvents::UPDATE][] = ['onEntityEvent', 300];
        $events[EntityEvents::DELETE][] = ['onEntityEvent', 300];

        return $events;
    }

    public function onEntityEvent(EntityEvent $event, $event_name): void
    {
        switch ($event_name) {
            case EntityEvents::INSERT:
                $this->onEntityEdit($event->getEntity(), $event->getPathAlias(), 'insert');
                break;

            case EntityEvents::UPDATE:
                $this->onEntityEdit($event->getEntity(), $event->getPathAlias(), 'update');
                break;

            case EntityEvents::DELETE:
                $this->onEntityDelete($event->getEntity(), $event->getPathAlias());
                break;
        }
    }
}
