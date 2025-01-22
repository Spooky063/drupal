<?php

declare(strict_types=1);

namespace Drupal\date\ValueObect;

final readonly class DateValue implements DateValueInterface
{
    private ?int $timestamp;

    public function __construct(?int $timestamp = null)
    {
        $this->timestamp = $timestamp ?? time();
    }

    #[\Override]
    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }
}
