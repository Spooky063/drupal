<?php

declare(strict_types = 1);

namespace Drupal\Tests\access\Unit;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Session\AccountInterface;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\access\Access\SeePageAccess
 * @group access
 */
class SeePageAccessTest extends UnitTestCase
{
  private $accessHandler;

  protected function setUp(): void
  {
    parent::setUp();

    $this->accessHandler = new class() {
      public function access(AccountInterface $user)
      {
        return $user->hasPermission('see page')
          ? AccessResult::allowed()
          : AccessResult::forbidden();
      }
    };
  }

  public function testPermissionSeePageAllowed(): void
  {
    $user = $this->createMock('Drupal\Core\Session\AccountInterface');
    $user->method('hasPermission')->with('see page')->willReturn(TRUE);

    $result = $this->accessHandler->access($user);
    $this->assertInstanceOf('Drupal\Core\Access\AccessResultAllowed', $result);
  }

  public function testPermissionSeePageForbidden(): void
  {
    $user = $this->createMock('Drupal\Core\Session\AccountInterface');
    $user->method('hasPermission')->with('see page')->willReturn(FALSE);

    $result = $this->accessHandler->access($user);
    $this->assertInstanceOf('Drupal\Core\Access\AccessResultForbidden', $result);
  }
}
