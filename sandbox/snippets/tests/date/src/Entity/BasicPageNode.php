<?php

declare(strict_types = 1);

namespace Drupal\date\Entity;

use Drupal\node\Entity\Node;

final class BasicPageNode extends Node
{
  public function getBody(): string
  {
    return $this->get('body')->value;
  }

  public function getSummary(): string
  {
    return $this->get('body')->summary;
  }
}
