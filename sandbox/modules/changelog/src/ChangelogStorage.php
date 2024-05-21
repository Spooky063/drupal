<?php

declare(strict_types=1);

namespace Drupal\changelog;

use Drupal\changelog\Entity\ChangelogInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorage;

class ChangelogStorage extends SqlContentEntityStorage implements ChangelogStorageInterface
{
  public function loadAllByDate(): array
  {
    $ids = $this->getQuery()
      ->condition('status', ChangelogInterface::PUBLISHED)
      ->condition('langcode', $this->languageManager->getCurrentLanguage()->getId())
      ->sort('release', 'DESC')
      ->execute();

    return $this->loadMultiple($ids);
  }
}
