<?php

declare(strict_types=1);

namespace Drupal\date\Entity;

use Drupal\node\Entity\Node;

final class BasicPageNode extends Node implements BasicPageNodeInterface
{
    public function getBody(): mixed
    {
        return $this->get('body')->value;
    }

    public function getSummary(): mixed
    {
        return $this->get('body')->summary ?? '';
    }
}
