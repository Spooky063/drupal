<?php

declare(strict_types=1);

namespace Drupal\time_office_field;

use DateTime;

class Time
{
    private int $hour;

    private int $minute;

    private int $second;

    public function __construct(int $hour = 0, int $minute = 0, int $second = 0)
    {
        self::assertInRange($hour, 0, 23);
        self::assertInRange($minute, 0, 59);
        self::assertInRange($second, 0, 59);

        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    public function getHour(): int
    {
        return $this->hour;
    }

    public function getMinute(): int
    {
        return $this->minute;
    }

    public function getSecond(): int
    {
        return $this->second;
    }

    public function getTimestamp(): int
    {
        $value = $this->hour * 60 * 60;
        $value += $this->minute * 60;
        $value += $this->second;

        return $value;
    }

    public static function createFromTimestamp(int $timestamp): self
    {
        self::assertInRange($timestamp, 0, 86400);

        $time = self::baseDateTime();
        $time->setTimestamp($time->getTimestamp() + $timestamp);

        return new self(
            (int) $time->format('H'),
            (int) $time->format('i'),
            (int) $time->format('s')
        );
    }

    public static function createFromHtml5Format(?string $string): self
    {
        if ($string === '' || $string === null) {
            return new self();
        }

        $inputs = explode(':', $string);
        if (\count($inputs) === 2) {
            $inputs[] = 0;
        }

        [$hour, $minute, $seconds] = $inputs;

        return new self((int) $hour, (int) $minute, (int) $seconds);
    }

    public function format(string $format = 'h:i a'): string
    {
        $time = self::baseDateTime();
        $time->setTimestamp($time->getTimestamp() + $this->getTimestamp());

        return $time->format($format);
    }

    public function formatForWidget(bool $show_seconds = true): string
    {
        $time = self::baseDateTime();
        $time->setTimestamp($time->getTimestamp() + $this->getTimestamp());

        if ($show_seconds) {
            return $time->format('H:i:s');
        }

        return $time->format('H:i');
    }

    public function on(DateTime $dateTime): Datetime
    {
        $instance = new DateTime();
        $instance->setTimestamp($dateTime->getTimestamp());
        $instance->setTime(0, 0, 0);
        $instance->setTimestamp($instance->getTimestamp() + $this->getTimestamp());

        return $instance;
    }

    private static function assertInRange(int $value, int $from, int $to): void
    {
        if ($value < $from || $value > $to) {
            throw new \InvalidArgumentException('Provided value is out of range.');
        }
    }

    private static function baseDateTime(): DateTime
    {
        return new DateTime('2012-01-01 00:00:00');
    }
}
