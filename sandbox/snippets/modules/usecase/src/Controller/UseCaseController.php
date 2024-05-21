<?php

declare(strict_types=1);

namespace Drupal\usecase\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\usecase\Presenter\ItemListUsecasePresenter;
use Drupal\usecase\UseCase\ListUsecase;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class UsecaseTestImplementation extends ControllerBase
{
    public function __construct(private ListUsecase $listUsecaseTest)
    {
    }

    public static function create(ContainerInterface $container): self
    {
        return new static(
            $container->get('usecase.test.list'),
        );
    }

    public function __invoke(): array
    {
        $presenter = new ItemListUsecasePresenter();
        $list = $this->listUsecaseTest->execute($presenter);

        return [
            '#theme' => 'item_list',
            '#type' => 'ul',
            '#attributes' => array('class' => 'container'),
            '#items' => $list
        ];
    }
}
