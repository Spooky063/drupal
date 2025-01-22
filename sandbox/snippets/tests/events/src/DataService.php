<?php

declare(strict_types=1);

namespace Drupal\events;

use Drupal\events\Event\DataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final readonly class DataService
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    /**
     * @return array<array-key, string>
     */
    public function execute(): array
    {
        $event = new DataEvent(['Hello world']);
        $this->eventDispatcher->dispatch($event, DataEvent::EVENT_NAME);

        return $event->getData();
    }
}
