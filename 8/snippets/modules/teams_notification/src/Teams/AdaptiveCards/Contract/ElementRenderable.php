<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Contract;

interface ElementRenderable
{
    public function render(): array;
}
