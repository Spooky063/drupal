<?php

declare(strict_types=1);

namespace Drupal\usecase\Repository;

use Drupal\usecase\Contract\UsecaseRepositoryInterface;

final class Usecase implements UsecaseRepositoryInterface
{
    public function find(): array
    {
        return [
            ['title' => 'Real data 1'],
            ['title' => 'Real data 2'],
            ['title' => 'Real data 3'],
            ['title' => 'Real data 4'],
        ];
    }
}
