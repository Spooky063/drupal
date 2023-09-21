<?php

declare(strict_types=1);

namespace Drupal\usecase\UseCase;

use Drupal\usecase\Contract\ListUsecasePresenterInterface;
use Drupal\usecase\Contract\UsecaseRepositoryInterface;

final class ListUsecase
{
    public function __construct(private UsecaseRepositoryInterface $repository)
    {
    }

    public function execute(ListUsecasePresenterInterface $presenter): array
    {
        $list = $this->repository->find();

        return $presenter->present($list);
    }
}
