<?php

declare(strict_types=1);

namespace Drupal\Tests\example\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * @group example
 */
final class ExampleKernelTest extends KernelTestBase
{
    /** @var array<string> */
    protected static $modules = ['system'];

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testKernelFake(): void
    {
        $this->assertNull(null, 'My kernel test will not work!');
    }

    public function testSiteName(): void
    {
        $config = $this->config('system.site');
        $config->set('name', 'Example');
        $config->save();

        $this->assertEquals($config->get('name'), 'Example');
    }
}
