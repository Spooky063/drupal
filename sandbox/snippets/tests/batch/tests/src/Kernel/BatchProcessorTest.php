<?php

declare(strict_types=1);

namespace Drupal\Tests\batch\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * @group batch
 * @coversDefaultClass \Drupal\batch\BatchProcessor
 */
class BatchProcessorTest extends KernelTestBase
{
  protected static $modules = [
    'system',
    'batch'
  ];

  public function testBatchProcessingWithStub(): void
  {
    $chunkSize = 10;
    $arrayLength = 100;
    $items = array_chunk(range(1, $arrayLength), $chunkSize);

    $batch_processor = $this->container->get('batch.processor');
    $batch_processor->execute($items);

    $batch = &batch_get();
    $this->assertNotEmpty($batch);

    $context = ['results' => [], 'sandbox' => ['progress' => 0]];
    $callback = function (&$args, &$context) {
      foreach ($args as $arg) {
        $context['results'][] = 'Processed Item ' . $arg;
        $context['sandbox']['progress']++;
      }
    };
    foreach ($items as $item) {
      call_user_func_array($callback, [&$item, &$context]);
      $this->assertCount($chunkSize, $item);
    }

    $this->assertEquals($arrayLength, count($context['results']));
    $this->assertEquals($arrayLength, $context['sandbox']['progress']);
  }

  public function testBatchProcessingWithCallback(): void
  {
    $this->markTestSkipped('Test with real operation skipped for performance reasons.');

    $chunkSize = 10;
    $arrayLength = 10;
    $items = array_chunk(range(1, $arrayLength), $chunkSize);

    $batch_processor = $this->container->get('batch.processor');
    $batch_processor->execute($items);

    $batch = &batch_get();
    $this->assertNotEmpty($batch);

    $values = reset($batch['sets']);
    foreach ($values['operations'] as $operation) {
      [$callback, $args] = $operation;

      $context = ['results' => [], 'message' => ''];

      // Execute the real operation.
      call_user_func_array($callback, array_merge($args, [&$context]));

      $this->assertNotEmpty($context['results']);
      $this->assertCount($context['results']['progress'], $args[1]);
      $this->assertEquals($arrayLength, $context['results']['progress']);
    }
  }

  public function testBatchFinishedCallbackWithNoErrors(): void
  {
    $items = [];

    $batch_processor = $this->container->get('batch.processor');
    $batch_processor->execute($items);

    $messenger = $this->container->get('messenger');
    $this->assertEmpty($messenger->all());

    $batch_processor->finishedCallback(TRUE, $items);

    $messages = $messenger->all();
    $this->assertNotEmpty($messages['status']);
    $this->assertStringContainsString('The batch finished successfully.', (string) $messages['status'][0]);
  }

  public function testBatchFinishedCallbackWithErrors(): void
  {
    $items = [];

    $batch_processor = $this->container->get('batch.processor');
    $batch_processor->execute($items);

    $messenger = $this->container->get('messenger');
    $this->assertEmpty($messenger->all());

    $batch_processor->finishedCallback(FALSE, $items);

    $messages = $messenger->all();
    $this->assertNotEmpty($messages['error']);
    $this->assertStringContainsString('The batch failed.', (string) $messages['error'][0]);
  }
}
