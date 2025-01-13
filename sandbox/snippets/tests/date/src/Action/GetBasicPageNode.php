<?php

declare(strict_types=1);

namespace Drupal\date\Action;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\date\ValueObect\DateValueInterface;

final readonly class GetBasicPageNode
{
  protected EntityTypeManagerInterface $entityTypeManager;

  protected DateValueInterface $dateValue;

  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
    DateValueInterface $dateValue,
  ) {
    $this->entityTypeManager = $entityTypeManager;
    $this->dateValue = $dateValue;
  }

  /**
   * @return \Drupal\node\NodeInterface[]
   */
  public function execute(): array
  {
    $timestamp = $this->dateValue->getTimestamp();

    $query = \Drupal::entityQuery('node')
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
    /** @var \Drupal\node\NodeInterface[] $nodes */
    $nodes = $node_storage->loadMultiple($nids);

    return array_values($nodes);
  }
}
