<?php

declare(strict_types=1);

namespace Drupal\Tests\batch\Unit;

use Drupal\batch\BatchProcessor;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Tests\UnitTestCase;

/**
 * @group batch
 * @coversDefaultClass \Drupal\batch\BatchProcessor
 */
class BatchProcessorTest extends UnitTestCase
{
  public function testBatchProcessorConstructor(): void
  {
      $messenger = $this->createMock(MessengerInterface::class);
      $this->assertInstanceOf(MessengerInterface::class, $messenger);

      $batchProcessor = new BatchProcessor($messenger);
      $this->assertInstanceOf(BatchProcessor::class, $batchProcessor);
  }

  public function testBatchPreparing(): void
  {
    $items = array_chunk(range(1, 100), 10);

    $messenger = $this->createMock(MessengerInterface::class);
    $batchProcessor = new BatchProcessor($messenger);

    $batch = $batchProcessor->prepareBatch($items);

    $this->assertArrayHasKey('error_message', $batch);

    $this->assertArrayHasKey('title', $batch);
    $this->assertInstanceOf(TranslatableMarkup::class, $batch['title']);
    $this->assertEquals(new TranslatableMarkup('Batch Title'), $batch['title']);

    $this->assertArrayHasKey('finished', $batch);

    $this->assertArrayHasKey('init_message', $batch);
    $this->assertInstanceOf(TranslatableMarkup::class, $batch['init_message']);
    $this->assertEquals(new TranslatableMarkup('The initialization message (optional)'), $batch['init_message']);

    $this->assertArrayHasKey('error_message', $batch);
    $this->assertInstanceOf(TranslatableMarkup::class, $batch['error_message']);
    $this->assertEquals(new TranslatableMarkup('An error occurred during processing.'), $batch['error_message']);

    $this->assertArrayHasKey('operations', $batch);
    $this->assertNotEmpty($batch['operations']);
    $this->assertCount(10, $batch['operations']);
  }

  public function testBatchProcess(): void
  {
    $items = array_chunk(range(1, 100), 10);

    $messenger = $this->createMock(MessengerInterface::class);
    $batchProcessor = new BatchProcessor($messenger);

    $context = [];
    $batchProcessor->processItem(1, $items, $context);

    $this->assertArrayHasKey('sandbox', $context);
    $this->assertArrayHasKey('results', $context);
    $this->assertEquals(1000, $context['sandbox']['max']);
    $this->assertEquals(10, $context['results']['updated']);
    $this->assertEquals(10, $context['results']['progress']);
  }
}
