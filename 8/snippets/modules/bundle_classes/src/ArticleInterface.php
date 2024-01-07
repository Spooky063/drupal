<?php

declare(strict_types=1);

namespace Drupal\bundle_classes;

use Drupal\node\NodeInterface;

interface ArticleInterface extends NodeInterface
{
    public function getBody(): string;

    public function getImage(): ?string;
}
