<?php

declare(strict_types=1);

namespace Drupal\node_alias\EventSubscriber;

use Drupal\Core\Entity\EntityInterface;
use Drupal\node_alias\Entity\PathAlias;

interface NodeEventSubscriberInterface
{

    public function onNodeEdit(EntityInterface $entity, PathAlias $pathAlias, string $op): void;

    public function onNodeDelete(EntityInterface $entity, PathAlias $pathAlias): void;

}
