<?php

declare(strict_types=1);

namespace Drupal\events;

use Drupal\events\Event\DataEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class DataService
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {
    }

    public function execute(): array
    {
        $event = new DataEvent(['Hello world']);
        $this->eventDispatcher->dispatch($event, DataEvent::EVENT_NAME);

        /** @var array<array-key, string> $data */
        $data = $event->getData();
        return $data;
    }
}
