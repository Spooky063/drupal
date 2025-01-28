<?php

declare(strict_types=1);

namespace Drupal\Tests\queue\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\KernelTests\Core\Queue\QueueTest;
use Drupal\queue\Plugin\QueueWorker\ArticleQueueWorker;
use Drupal\queue\Queue\ArticleQueue;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\Queue\QueueInterface;

/**
 * @group queue
 * @coversDefaultClass \Drupal\queue\Plugin\QueueWorker\ArticleQueueWorker
 */
final class ArticleQueueWorkerTest extends UnitTestCase
{
  protected function setUp(): void
  {
    parent::setUp();

    $queue = $this->createMock('Drupal\Core\Queue\QueueInterface');
    $queue->method('createItem')->willReturn(true);
    $queue->method('claimItem')->willReturn((object)['data' => new ArticleQueue('Test')]);
    $queue->method('numberOfItems')->willReturn(1);

    $queueFactory = $this->createMock('Drupal\Core\Queue\QueueFactory');
    $queueFactory->method('get')->with(ArticleQueueWorker::PLUGIN_ID)->willReturn($queue);

    $container = new ContainerBuilder();
    $container->set('queue_factory', $queueFactory);
    \Drupal::setContainer($container);
  }

  public function testQueueWorkerCreate(): void
  {
    $queueFactory = \Drupal::service('queue_factory');
    $queue = $queueFactory->get(ArticleQueueWorker::PLUGIN_ID);

    $this->assertNotNull($queue);

    $item = $queue->claimItem();
    $this->assertInstanceOf(ArticleQueue::class, $item->data);
    $this->assertEquals('Test', $item->data->getTitle());

    $this->assertEquals(1, $queue->numberOfItems());
  }

  public function testQueueWorkerProcess(): void
  {
    /** @var ArticleQueueWorker $queue */
    $queue = $this->createMock(ArticleQueueWorker::class);
    $this->assertInstanceOf(ArticleQueueWorker::class, $queue);

    $item = new ArticleQueue('Test');
    $process = $queue->processItem($item);
  }

}
