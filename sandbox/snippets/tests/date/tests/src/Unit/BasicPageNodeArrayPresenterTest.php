<?php

declare(strict_types=1);

namespace Drupal\Tests\date\Unit;

use Drupal\date\Presenter\BasicPageNodeArrayPresenter;
use Drupal\node\NodeInterface;
use Drupal\Tests\UnitTestCase;

/**
 * @group date
 * @coversDefaultClass \Drupal\date\Presenter\BasicPageNodeArrayPresenter
 */
class BasicPageNodeArrayPresenterTest extends UnitTestCase
{
  public function testPresent(): void
  {
    $nodeMock = $this->createMock(NodeInterface::class);
    $nodeMock->method('id')->willReturn(1);
    $nodeMock->method('label')->willReturn('Page 1');
    $nodeMock->method('getCreatedTime')->willReturn(strtotime('2025-01-01 10:00:00'));

    $nodes = [$nodeMock];

    $presenter = new BasicPageNodeArrayPresenter($nodes);
    $result = $presenter->present();

    $expected = [
      [
        'id' => 1,
        'title' => 'Page 1',
        'created' => '2025-01-01 10:00:00',
      ],
    ];

    $this->assertEquals($expected, $result);
  }
}
