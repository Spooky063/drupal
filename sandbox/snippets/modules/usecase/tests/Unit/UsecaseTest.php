<?php

declare(strict_types=1);

namespace Drupal\Tests\usecase\Unit;

use Drupal\usecase\Presenter\ItemListUsecasePresenter;
use Drupal\usecase\Repository\UsecaseDummy;
use Drupal\usecase\UseCase\ListUsecase;
use Drupal\Tests\UnitTestCase;

/**
 * @group usecase
 */
final class UsecaseTest extends UnitTestCase
{
    public function testRepository(): void
    {
        $dummyRepository = new UsecaseDummy();
        $useCase = new ListUsecase($dummyRepository);
        $presenter = new ItemListUsecasePresenter();

        $this->assertEquals([
                'Dummy 1',
                'Dummy 2',
                'Dummy 3',
            ],
            $useCase->execute($presenter)
        );
    }
}
