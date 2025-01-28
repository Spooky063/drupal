<?php

declare(strict_types = 1);

namespace Drupal\Tests\access\Unit;

use Drupal\access\Access\SeePageAccess;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\access\Access\SeePageAccess
 * @group access
 */
class SeePageAccessTest extends UnitTestCase
{
  protected function setUp(): void
  {
    parent::setUp();

    $access = $this->createMock('Drupal\access\Access\SeePageAccess');

    $cacheContextManager = $this->createMock('Drupal\Core\Cache\Context\CacheContextsManager');
    $cacheContextManager->method('assertValidTokens')->willReturn(true);

    $container = new ContainerBuilder();
    $container->set('access.see_page_access_checker', $access);
    $container->set('cache_contexts_manager', $cacheContextManager);
    \Drupal::setContainer($container);
  }

  public function testPermissionSeePageAllowed(): void
  {
    $user = $this->createMock('Drupal\Core\Session\AccountInterface');
    $user->method('hasPermission')->with('see page')->willReturn(TRUE);

    $access = new SeePageAccess();
    $result = $access->access($user);
    $this->assertInstanceOf('Drupal\Core\Access\AccessResultAllowed', $result);
  }

  public function testPermissionSeePageForbidden(): void
  {
    $user = $this->createMock('Drupal\Core\Session\AccountInterface');
    $user->method('hasPermission')->with('see page')->willReturn(FALSE);

    $access = new SeePageAccess();
    $result = $access->access($user);
    $this->assertInstanceOf('Drupal\Core\Access\AccessResultForbidden', $result);
  }
}
