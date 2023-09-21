<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Elements;

use Drupal\notify\Teams\AdaptiveCards\Contract\ElementRenderable;

final class ColumnSet implements ElementRenderable
{
    /** @var ElementRenderable[] $elements */
    private array $elements = [];

    public function render(): array
    {
        $build = [
            'type' => 'ColumnSet',
        ];

        foreach ($this->elements as $element) {
            $build['columns'][] = $element->render();
        }

        return $build;
    }

    public function addElement(Column $element): void
    {
        $this->elements[] = $element;
    }
}
