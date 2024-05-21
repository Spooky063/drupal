<?php

declare(strict_types=1);

namespace Drupal\faq;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\taxonomy\TermInterface;
use Drupal\user\EntityOwnerInterface;

interface FaqInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface, EntityPublishedInterface
{
    const NOT_PUBLISHED = 0;

    const PUBLISHED = 1;

    public function getQuestion(): string;

    public function setQuestion(string $question): self;

    public function getAnswer(): string;

    public function setAnswer(string $answer): self;

    public function getCategory(): ?TermInterface;

    public function setTop(bool $top): self;

    public function getTop(): bool;

    public function setCategory($category): self;

    public function getCreatedTime(): int;

    public function setCreatedTime(int $timestamp): self;

    public function getStatus(): bool;

    public function setStatus(bool $status): self;
}
