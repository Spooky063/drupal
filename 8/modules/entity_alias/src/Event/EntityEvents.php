<?php

declare(strict_types=1);

namespace Drupal\entity_alias\Event;

final class EntityEvents
{
    public const INSERT = 'entity.insert';

    public const UPDATE = 'entity.update';

    public const DELETE = 'entity.delete';
}
