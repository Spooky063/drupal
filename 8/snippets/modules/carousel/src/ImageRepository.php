<?php

declare(strict_types=1);

namespace Drupal\carousel;

use Drupal\Core\Entity\EntityTypeManagerInterface;

class ImageRepository
{
    public function __construct(private EntityTypeManagerInterface $entityTypeManager)
    {
    }

    /**
     * @return array<int, Slide>|null
     */
    public function getArticles()
    {
        $storage = $this->entityTypeManager->getStorage('node');
        $articles = $storage->loadByProperties(['type' => 'article']);
        return array_map(fn($article) => new Slide($article), $articles);
    }
}
