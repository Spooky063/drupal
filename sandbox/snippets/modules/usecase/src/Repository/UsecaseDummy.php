<?php

declare(strict_types=1);

namespace Drupal\usecase\Repository;

use Drupal\usecase\Contract\UsecaseRepositoryInterface;

final class UsecaseDummy implements UsecaseRepositoryInterface
{
    public function find(): array
    {
        return [
            'Dummy 1',
            'Dummy 2',
            'Dummy 3',
        ];
    }
}
