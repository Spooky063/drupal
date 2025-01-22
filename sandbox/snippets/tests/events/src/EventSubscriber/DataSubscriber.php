<?php

declare(strict_types=1);

namespace Drupal\events\EventSubscriber;

use Drupal\events\Event\DataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class DataSubscriber implements EventSubscriberInterface
{
    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            DataEvent::EVENT_NAME => 'onDataEvent',
        ];
    }

    /**
     * @param DataEvent<mixed> $event
     */
    public function onDataEvent(DataEvent $event): void
    {
        $data = $event->getData();

        // @phpstan-ignore-next-line
        \Drupal::logger('event_subscriber')->notice('Data event received: %data', ['%data' => json_encode($data)]);
    }
}
