<?php

declare(strict_types=1);

namespace Drupal\datalayer\PushEvent;

use Drupal\datalayer\DataLayer\DataLayerPushRenderable;

final class UserEditPushEvent implements DataLayerPushRenderable
{
    private string $name = '';

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function render(): array
    {
        return [
            'event' => 'edit',
            'name' => $this->name,
        ];
    }
}
