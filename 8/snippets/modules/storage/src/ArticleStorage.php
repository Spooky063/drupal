<?php

declare(strict_types=1);

namespace Drupal\storage;

class ArticleStorage extends AbstractStorage
{
    protected ?string $bundle = 'article';

    public function getPublishedArticles(): array
    {
        return $this->isPublished()
            ->execute();
    }

    public function countPublishedArticles(): int
    {
        return $this->isPublished()
            ->count()
            ->execute();
    }

    public function getPublishedArticlesWithSpecificTags(array $tags, string $fieldTagName = 'field_tags'): array
    {
        return $this->findItemByTags($fieldTagName, $tags)
            ->condition('status', true)
            ->execute();
    }

    public function countArticles(): int
    {
        $result = $this->getAggregateQuery()
            ->aggregate('nid', 'COUNT')
            ->execute();

        /** @var array $count */
        $count = reset($result);
        if (count($count) === 0) {
          return 0;
        }

        return isset($count['nid_count']) ? $count['nid_count'] : 0;
    }
}
