<?php

declare(strict_types=1);

namespace Drupal\storage;

use Drupal\Core\Entity\Query\ConditionInterface;
use Drupal\Core\Entity\Query\QueryInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

abstract class AbstractStorage extends SqlContentEntityStorage
{
    protected ?string $bundle;

    public function getQuery($conjunction = 'AND'): QueryInterface
    {
        $query = parent::getQuery($conjunction);
        if (!$this->bundle || empty($this->bundle)) {
            return $query;
        }
        return $query->condition('type', $this->bundle);
    }

    public function isPublished(): QueryInterface
    {
        $query = $this->getQuery()->accessCheck(false);
        return $query->condition('status', true);
    }

    public function isUnpublished(): QueryInterface
    {
        $query = $this->getQuery()->accessCheck(false);
        return $query->condition('status', false);
    }

    public function findItemByTags(string $fieldName, array $tags): QueryInterface
    {
        $query = $this->getQuery();
        $fieldName .= '.entity.name';
        $orGroup = array_reduce(
            $tags,
            static function (ConditionInterface $orCondition, string $tag) use ($fieldName) {
                return $orCondition->condition($fieldName, $tag, 'LIKE');
            },
            $query->orConditionGroup()
        );
        return $query->condition($orGroup);
    }
}
