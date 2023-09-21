<?php

declare(strict_types=1);

namespace Drupal\usecase\Presenter;

use Drupal\usecase\Contract\ListUsecasePresenterInterface;

final class ItemListUsecasePresenter implements ListUsecasePresenterInterface
{
    public function present(array $list): array
    {
        return array_map(fn ($item) => \is_countable($item) && isset($item['title']) ? $item['title'] : $item, $list);
    }
}
