<?php

declare(strict_types=1);

namespace Drupal\Tests\example\Unit;

use Drupal\example\Example;
use Drupal\Tests\UnitTestCase;

/**
 * @group example
 * @covers Drupal\example\Example
 */
final class ExampleUnitTest extends UnitTestCase
{
    public function testUnitFake(): void
    {
        $example = new Example('foo');

        $this->assertEquals('foo', $example->getBar());
    }
}
