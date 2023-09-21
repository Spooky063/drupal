<?php

declare(strict_types=1);

namespace Drupal\usecase\Contract;

interface UsecaseRepositoryInterface
{
    public function find(): array;
}
