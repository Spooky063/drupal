<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Elements;

use Drupal\notify\Teams\AdaptiveCards\Contract\ActionRenderable;

final class ActionOpenUrl implements ActionRenderable
{
    public function __construct(
        private readonly string $title = '',
        private readonly string $url = '',
        private readonly string $type = 'Action.OpenUrl',
    ) {
    }

    public function render(): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'url' => $this->url
        ];
    }
}
