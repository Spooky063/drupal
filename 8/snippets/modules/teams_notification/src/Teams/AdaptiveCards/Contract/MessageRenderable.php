<?php

declare(strict_types=1);

namespace Drupal\notify\Teams\AdaptiveCards\Contract;

interface MessageRenderable
{
    public function render(): array;
}
