<?php

declare(strict_types=1);

namespace Drupal\batch;

use Drupal\Core\Batch\BatchBuilder;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

final readonly class BatchProcessor
{
    public function __construct(
        private MessengerInterface $messenger
    ) {
    }

    /**
     * @return array<array-key, mixed>
     */
    public function prepareBatch(array $items): array
    {
        $batch_builder = new BatchBuilder();
        $batch_builder
            ->setTitle(new TranslatableMarkup('Batch Title'))
            ->setFinishCallback($this->finishedCallback(...))
            ->setInitMessage(new TranslatableMarkup('The initialization message (optional)'))
            ->setErrorMessage(new TranslatableMarkup('An error occurred during processing.'))
        ;

        foreach ($items as $id => $item) {
            $args = [$id, $item];
            $batch_builder->addOperation($this->processItem(...), $args);
        }

        return $batch_builder->toArray();
    }

    public function execute(array $items): void
    {
        $batch = $this->prepareBatch($items);
        batch_set($batch);
    }

    public function processItem(int $id, array $items, array &$context): void
    {
        if (!isset($context['sandbox']['progress'])) {
            $context['sandbox']['progress'] = 0;
            $context['sandbox']['max'] = 1000;
        }

        if (!isset($context['results']['updated'])) {
            $context['results']['updated'] = 0;
            $context['results']['skipped'] = 0;
            $context['results']['failed'] = 0;
            $context['results']['progress'] = 0;
            $context['results']['process'] = 'Form batch completed';
        }

        $context['results']['progress'] += count($items);

        $context['message'] = new TranslatableMarkup(
            'Processing batch #@batch_id batch size @batch_size for total @count items.',
            [
                '@batch_id' => number_format($id),
                '@batch_size' => number_format(count($items)),
                '@count' => number_format($context['sandbox']['max']),
            ]
        );

        // Do something with the items.
        foreach ($items as $item) {
            usleep(200_000);
            $context['results']['updated']++;
        }
    }

    public function finishedCallback(bool $success, array $results): void
    {
        if ($success) {
            $this->messenger->addStatus(
                new TranslatableMarkup(
                    'The batch finished successfully. Processed items: @count',
                    [
                        '@count' => count($results),
                    ]
                )
            );
        } else {
            $this->messenger->addError(
                new TranslatableMarkup(
                    'The batch failed. Processed items: @count',
                    [
                        '@count' => count($results),
                    ]
                )
            );
        }
    }
}
