<?php

declare(strict_types = 1);

namespace Drupal\Tests\access\Kernel;

use Drupal\access\Access\SeePageAccess;
use Drupal\KernelTests\KernelTestBase;
use Drupal\user\Entity\Role;
use Drupal\user\Entity\User;
use Drupal\user\RoleInterface;

/**
 * @coversDefaultClass \Drupal\access\Access\SeePageAccess
 * @group access
 */
class SeePageAccessTest extends KernelTestBase
{
  protected static $modules = [
    'system',
    'user',
    'access'
  ];

  protected RoleInterface $role;

  protected function setUp(): void
  {
    parent::setUp();
    $this->installSchema('user', ['users_data']);
    $this->installEntitySchema('user');

    $this->role = Role::create([
      'id' => 'test',
      'label' => 'test role',
    ]);
    $this->role->save();
  }

  public function testSeePageAccess(): void
  {
    $user = User::create([
      'name' => 'Someone',
      'mail' => 'hi@example.com',
    ]);

    $this->role->grantPermission('see page');
    $this->role->save();
    $user->addRole($this->role->id())->save();

    $access = new SeePageAccess();
    $result = $access->access($user);

    $this->assertTrue($user->hasPermission('see page'));
    $this->assertInstanceOf('Drupal\Core\Access\AccessResultAllowed', $result);
  }

  public function testSeePageForbidden(): void
  {
    $user = User::create([
      'name' => 'Someone',
      'mail' => 'hi@example.com',
    ]);

    $access = new SeePageAccess();
    $result = $access->access($user);

    $this->assertFalse($user->hasPermission('see page'));
    $this->assertInstanceOf('Drupal\Core\Access\AccessResultForbidden', $result);
  }
}
