<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Elements;

use Drupal\notify\Teams\AdaptiveCards\Contract\ActionRenderable;
use Drupal\notify\Teams\AdaptiveCards\Contract\ElementRenderable;

final class ActionSet implements ElementRenderable
{
    /** @var ActionRenderable[] $actions */
    private array $actions = [];

    public function render(): array
    {
        $build = [
            'type' => 'ActionSet',
        ];

        foreach ($this->actions as $action) {
            $build['actions'][] = $action->render();
        }

        return $build;
    }

    public function addAction(ActionRenderable $action): void
    {
        $this->actions[] = $action;
    }
}
