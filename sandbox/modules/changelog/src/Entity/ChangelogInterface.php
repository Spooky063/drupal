<?php

declare(strict_types=1);

namespace Drupal\changelog\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

interface ChangelogInterface extends
  ContentEntityInterface,
  EntityChangedInterface,
  EntityOwnerInterface,
  EntityPublishedInterface
{
  const NOT_PUBLISHED = 0;

  const PUBLISHED = 1;

  public function getRelease(): string;

  public function setRelease(string $release): self;

  public function getContent(): string;

  public function setContent(string $content): self;

  public function getCreatedTime(): int;

  public function setCreatedTime(int $timestamp): self;

  public function getStatus(): bool;

  public function setStatus(bool $status): self;
}
