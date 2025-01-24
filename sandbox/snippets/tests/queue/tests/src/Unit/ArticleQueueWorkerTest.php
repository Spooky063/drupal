<?php

declare(strict_types=1);

namespace Drupal\Tests\queue\Unit;

use Drupal\queue\Plugin\QueueWorker\ArticleQueueWorker;
use Drupal\queue\Queue\ArticleQueue;
use Drupal\Tests\UnitTestCase;

/**
 * @group queue
 * @coversDefaultClass \Drupal\queue\Plugin\QueueWorker\ArticleQueueWorker
 */
final class ArticleQueueWorkerTest extends UnitTestCase
{
  public function testQueueWorkerCreate(): void
  {
    /** @var ArticleQueueWorker $queue */
    $queue = $this->createMock(ArticleQueueWorker::class);
    $this->assertInstanceOf(ArticleQueueWorker::class, $queue);

    $item = new ArticleQueue('Test');
    $process = $queue->processItem($item);
  }

}
