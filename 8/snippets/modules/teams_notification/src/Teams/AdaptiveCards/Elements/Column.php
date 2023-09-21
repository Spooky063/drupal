<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Elements;

use Drupal\notify\Teams\AdaptiveCards\Contract\ElementRenderable;

final class Column implements ElementRenderable
{
    /** @var ElementRenderable[] $items */
    private array $items = [];

    public function __construct(
        private readonly array $options = [],
    ) {
    }

    public function render(): array
    {
        $build = [
            'type' => 'Column',
        ] + $this->options;

        foreach ($this->items as $item) {
            $build['items'][] = $item->render();
        }

        return $build;
    }

    public function addItem(ElementRenderable $item): void
    {
        $this->items[] = $item;
    }
}
