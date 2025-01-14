<?php

declare(strict_types = 1);

namespace Drupal\date\Entity;

use Drupal\node\NodeInterface;

interface BasicPageNodeInterface extends NodeInterface
{
  public function getBody(): string;

  public function getSummary(): string;
}
