<?php

declare(strict_types=1);

namespace Drupal\changelog;

interface ChangelogStorageInterface
{
  public function loadAllByDate(): array;
}
