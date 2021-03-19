<?php

declare(strict_types=1);

namespace Drupal\permission_view\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class PermissionViewAccessControlHandler extends EntityAccessControlHandler
{
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
    {
        switch ($operation) {
            case 'view':
                if ($account->hasPermission('administer taxonomy')) {
                    return AccessResult::allowed();
                    break;
                }

                return AccessResult::allowedIfHasPermissions($account, ["permission_view_taxonomy_{$entity->bundle()}", "view {$entity->bundle()} terms"], 'OR');
                break;

            case 'update':
                return AccessResult::allowedIfHasPermissions($account, ["edit terms in {$entity->bundle()}", 'administer taxonomy'], 'OR');
                break;

            case 'delete':
                return AccessResult::allowedIfHasPermissions($account, ["delete terms in {$entity->bundle()}", 'administer taxonomy'], 'OR');
                break;

            default:
                return AccessResult::neutral();
        }
    }
}
