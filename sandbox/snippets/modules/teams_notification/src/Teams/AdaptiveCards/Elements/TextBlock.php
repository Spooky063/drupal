<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Elements;

use Drupal\notify\Teams\AdaptiveCards\Contract\ElementRenderable;

final class TextBlock implements ElementRenderable
{
    public function __construct(
        private readonly string $text = '',
        private readonly array $options = [],
    ) {
    }

    public function render(): array
    {
        return [
            'type' => 'TextBlock',
            'text' => $this->text,
        ] + $this->options;
    }
}
