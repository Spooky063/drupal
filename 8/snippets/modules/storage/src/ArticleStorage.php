<?php

declare(strict_types=1);

namespace Drupal\storage;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
use Drupal\node\NodeInterface;

class ArticleStorage extends SqlContentEntityStorage
{
    private string $bundle = 'article';

    /**
     * @return EntityInterface[]
     */
    public function getAllArticles()
    {
        return $this->loadByProperties(
            [
            'type' => $this->bundle,
            'status' => NodeInterface::PUBLISHED,
            ]
        );
    }
}
