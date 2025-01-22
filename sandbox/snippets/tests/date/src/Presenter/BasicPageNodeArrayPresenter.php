<?php

declare(strict_types=1);

namespace Drupal\date\Presenter;

use Drupal\date\Entity\BasicPageNodeInterface;

final readonly class BasicPageNodeArrayPresenter
{
    /**
     * @param array<BasicPageNodeInterface> $nodes
     */
    public function __construct(private array $nodes)
    {
    }

    /**
     * @return array<array{id: int, title: string, created: string}>
     */
    public function present(): array
    {
        return array_map(static fn ($node): array => [
            'id' => (int) $node->id(),
            'title' => (string) $node->label(),
            'created' => date('Y-m-d H:i:s', (int) $node->getCreatedTime()),
        ], $this->nodes);
    }
}
