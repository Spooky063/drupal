<?php

declare(strict_types=1);

namespace Drupal\Tests\queue\Kernel;

use Drupal\Core\CronInterface;
use Drupal\KernelTests\KernelTestBase;
use Drupal\queue\Plugin\QueueWorker\ArticleQueueWorker;
use Drupal\queue\Queue\ArticleQueue;

/**
 * @group queue
 * @coversDefaultClass \Drupal\queue\Plugin\QueueWorker\ArticleQueueWorker
 */
final class ArticleQueueWorkerTest extends KernelTestBase
{
  protected static $modules = [
    'system',
    'queue',
  ];

  protected CronInterface $cron;

  protected function setUp(): void
  {
    parent::setUp();

    $this->cron = \Drupal::service('cron');
  }

  public function testQueueWorkerCreate(): void
  {
    $queue = $this->container->get('queue')->get(ArticleQueueWorker::PLUGIN_ID);
    $item = new ArticleQueue('Test');
    $queue->createItem($item);

    $item = $queue->claimItem();
    $this->assertInstanceOf(ArticleQueue::class, $item->data);
    $this->assertEquals('Test', $item->data->getTitle());

    $this->assertEquals(1, $queue->numberOfItems());
  }

  public function testQueueWorker(): void
  {
    $queue = $this->container->get('queue')->get(ArticleQueueWorker::PLUGIN_ID);
    $item = new ArticleQueue('Test');
    $queue->createItem($item);

    $this->cron->run();

    $this->assertEquals(0, $queue->numberOfItems());
  }

  public function testQueueWorkerException(): void
  {
    $queue = $this->container->get('queue')->get(ArticleQueueWorker::PLUGIN_ID);
    $queue->createItem('Test');

    $this->cron->run();

    $this->assertEquals(1, \Drupal::state()->get('queue_requeue_exception'));
    $this->assertEquals(1, $queue->numberOfItems());
  }
}
