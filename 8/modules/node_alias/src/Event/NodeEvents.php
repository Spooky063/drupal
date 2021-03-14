<?php

declare(strict_types=1);

namespace Drupal\node_alias\Event;

final class NodeEvents
{
    public const INSERT = 'node.insert';

    public const UPDATE = 'node.update';

    public const DELETE = 'node.delete';
}
