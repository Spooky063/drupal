<?php

declare(strict_types=1);

namespace Drupal\permission_view\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\taxonomy\TermAccessControlHandler;

class PermissionViewAccessControlHandler extends TermAccessControlHandler
{
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account)
    {
        if ($account->hasPermission('administer taxonomy')) {
            return AccessResult::allowed()->cachePerPermissions();
        }

        switch ($operation) {
            case 'view':
                $activeTheme = \Drupal::theme()->getActiveTheme()->getName();
                $defaultTheme = \Drupal::service('theme_handler')->getDefault();

                if ($activeTheme === $defaultTheme) {
                    return AccessResult::allowedIfHasPermissions(
                        $account,
                        ["permission_view_taxonomy_{$entity->bundle()}"]
                    );
                } else {
                    return parent::checkAccess($entity, $operation, $account);
                }

            default:
                return parent::checkAccess($entity, $operation, $account);
        }
    }
}
