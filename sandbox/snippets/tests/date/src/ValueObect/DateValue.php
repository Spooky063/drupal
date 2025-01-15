<?php

declare(strict_types=1);

namespace Drupal\date\ValueObect;

final class DateValue implements DateValueInterface
{
    private readonly int $timestamp;

    public function __construct(int $timestamp = null)
    {
        $this->timestamp = $timestamp ?? time();
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }
}
