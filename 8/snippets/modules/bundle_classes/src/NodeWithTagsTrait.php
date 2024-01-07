<?php

declare(strict_types=1);

namespace Drupal\bundle_classes;

trait NodeWithTagsTrait
{
    public function getTags(): array
    {
        return $this->get('field_tags')->referencedEntities();
    }

    public function hasTags(): bool
    {
        return $this->hasField('field_tags') && \count($this->get('field_tags')->getValue()) !== 0;
    }
}
