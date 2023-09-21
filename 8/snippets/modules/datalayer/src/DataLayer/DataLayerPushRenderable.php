<?php

declare(strict_types=1);

namespace Drupal\datalayer\DataLayer;

interface DataLayerPushRenderable
{
    public function render(): array;
}
