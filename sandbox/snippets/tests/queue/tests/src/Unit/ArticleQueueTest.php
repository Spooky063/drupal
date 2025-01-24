<?php

declare(strict_types=1);

namespace Drupal\Tests\queue\Unit;

use Drupal\queue\Queue\ArticleQueue;
use Drupal\Tests\UnitTestCase;

/**
 * @group queue
 * @coversDefaultClass \Drupal\queue\Queue\ArticleQueue
 */
final class ArticleQueueTest extends UnitTestCase
{
  public function testQueue(): void
  {
    $queue = new ArticleQueue('Test');
    $this->assertInstanceOf(ArticleQueue::class, $queue);
    $this->assertEquals('Test', $queue->getTitle());
  }
}
