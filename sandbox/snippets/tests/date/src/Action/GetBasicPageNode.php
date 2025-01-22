<?php

declare(strict_types=1);

namespace Drupal\date\Action;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\date\Entity\BasicPageNodeInterface;
use Drupal\date\ValueObect\DateValueInterface;

final readonly class GetBasicPageNode
{
    public function __construct(
        private EntityTypeManagerInterface $entityTypeManager,
        private DateValueInterface $dateValue
    ) {
    }

    /**
     * @return array<BasicPageNodeInterface>
     */
    public function execute(): array
    {
        $timestamp = $this->dateValue->getTimestamp();

        $query = $this->entityTypeManager->getStorage('node')
            ->getQuery()
            ->condition('type', 'page')
            ->condition('created', $timestamp, '<=')
            ->sort('created', 'DESC')
            ->accessCheck()
        ;

        $nids = $query->execute();

        if (empty($nids)) {
            return [];
        }

        $node_storage = $this->entityTypeManager->getStorage('node');
        /** @var array<BasicPageNodeInterface> $nodes */
        $nodes = $node_storage->loadMultiple($nids);

        return array_values($nodes);
    }
}
