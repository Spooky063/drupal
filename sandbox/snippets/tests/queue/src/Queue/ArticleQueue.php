<?php

declare(strict_types=1);

namespace Drupal\queue\Queue;

final class ArticleQueue
{
    public function __construct(
        protected string $title,
    ) {
        $this->title = $title;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
