<?php

declare(strict_types=1);

namespace Drupal\Tests\events\Kernel;

use Drupal\events\Event\DataEvent;
use Drupal\KernelTests\KernelTestBase;

/**
 * @group events
 */
class EventTest extends KernelTestBase
{
  protected static $modules = [
    'system',
    'dblog',
    'events',
  ];

  protected function setUp(): void
  {
    parent::setUp();

    $this->installSchema('dblog', ['watchdog']);
  }

  public function testEventIsDispatched(): void
  {
    $eventDispatched = false;
    $capturedEvent = null;

    $listener = function (DataEvent $event) use (&$eventDispatched, &$capturedEvent) {
      $eventDispatched = true;
      $capturedEvent = $event;
    };

    $eventDispatcher = $this->container->get('event_dispatcher');
    $eventDispatcher->addListener(DataEvent::EVENT_NAME, $listener);

    /** @var \Drupal\events\DataService $dataService */
    $dataService = $this->container->get('events.data_service');
    $dataService->execute();

    $this->assertTrue($eventDispatched);
    $this->assertInstanceOf(DataEvent::class, $capturedEvent);
    $this->assertEquals(['Hello world'], $capturedEvent->getData());

    // Check the log message.
    $logs = $this->container->get('database')
      ->select('watchdog', 'w')
      ->fields('w', ['message', 'type', 'variables'])
      ->condition('type', 'event_subscriber')
      ->condition('message', 'Data event received:%', 'LIKE')
      ->execute()
      ->fetchAll();

    $this->assertNotEmpty($logs);

    $log = reset($logs);
    $variables = unserialize($log->variables);
    $this->assertStringContainsString('Hello world', $variables['%data']);
  }
}
