<?php

declare(strict_types=1);

namespace Drupal\date\ValueObect;

interface DateValueInterface
{
    public function getTimestamp(): ?int;
}
