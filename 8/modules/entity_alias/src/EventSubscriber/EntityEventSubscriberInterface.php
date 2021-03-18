<?php

declare(strict_types=1);

namespace Drupal\entity_alias\EventSubscriber;

use Drupal\Core\Entity\EntityInterface;
use Drupal\entity_alias\Entity\PathAlias;

interface EntityEventSubscriberInterface
{
    public function onEntityEdit(EntityInterface $entity, PathAlias $pathAlias, string $op): void;

    public function onEntityDelete(EntityInterface $entity, PathAlias $pathAlias): void;
}
