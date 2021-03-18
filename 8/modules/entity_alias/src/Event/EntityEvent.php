<?php

declare(strict_types=1);

namespace Drupal\entity_alias\Event;

use Drupal\Core\Entity\EntityInterface;
use Drupal\entity_alias\Entity\PathAlias;
use Symfony\Component\EventDispatcher\GenericEvent;

class EntityEvent extends GenericEvent
{
    protected EntityInterface $entity;

    protected PathAlias $pathAlias;

    public function __construct(EntityInterface $entity, PathAlias $pathAlias)
    {
        parent::__construct();

        $this->entity = $entity;
        $this->pathAlias = $pathAlias;
    }

    public function getEntity(): EntityInterface
    {
        return $this->entity;
    }

    public function getPathAlias(): PathAlias
    {
        return $this->pathAlias;
    }
}
