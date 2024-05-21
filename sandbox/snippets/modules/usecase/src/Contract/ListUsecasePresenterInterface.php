<?php

declare(strict_types=1);

namespace Drupal\usecase\Contract;

interface ListUsecasePresenterInterface
{
    public function present(array $list): array;
}
