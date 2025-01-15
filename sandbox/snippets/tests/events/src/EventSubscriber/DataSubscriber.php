<?php

declare(strict_types=1);

namespace Drupal\events\EventSubscriber;

use Drupal\events\Event\DataEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class DataSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
        DataEvent::EVENT_NAME => 'onDataEvent',
        ];
    }

    public function onDataEvent(DataEvent $event): void
    {
        $data = $event->getData();

        \Drupal::logger('event_subscriber')->notice('Data event received: %data', ['%data' => json_encode($data)]);
    }
}
