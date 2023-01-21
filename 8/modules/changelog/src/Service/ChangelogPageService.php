<?php

declare(strict_types=1);

namespace Drupal\changelog\Service;

use Drupal\changelog\ChangelogStorageInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\changelog\Entity\ChangelogInterface;

class ChangelogPageService
{
  protected EntityTypeManagerInterface $entityTypeManager;

  protected LanguageManagerInterface $languageManager;

  public function __construct(
    EntityTypeManagerInterface $entityTypeManager,
    LanguageManagerInterface $languageManager
  ) {
    $this->entityTypeManager = $entityTypeManager;
    $this->languageManager = $languageManager;
  }

  public function getAllChangelogOrderByReleaseDate(): array
  {
    /** @var ChangelogStorageInterface $changelogStorage */
    $changelogStorage = $this->entityTypeManager->getStorage('changelog');
    /** @var ChangelogInterface[] $items */
    $items = $changelogStorage->loadAllByDate();

    $changelogs = [];
    foreach ($items as $item) {
      $changelogs[$item->id()] = [
        'title' => $item->label(),
        'content' => $item->getContent(),
        'releaseDate' => $item->getRelease(),
      ];
    }

    return $changelogs;
  }

}
