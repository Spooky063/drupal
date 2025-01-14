<?php

declare(strict_types=1);

namespace Drupal\date\Presenter;

use Drupal\date\Entity\BasicPageNodeInterface;

final class BasicPageNodeArrayPresenter
{
  /** @var BasicPageNodeInterface[] */
  private array $nodes;

  /**
   * @param BasicPageNodeInterface[] $nodes
   */
  public function __construct(array $nodes)
  {
    $this->nodes = $nodes;
  }

  public function present(): array
  {
    return array_map(function($node) {
      return [
        'id' => $node->id(),
        'title' => $node->label(),
        'created' => date('Y-m-d H:i:s', (int) $node->getCreatedTime()),
      ];
    }, $this->nodes);
  }
}
