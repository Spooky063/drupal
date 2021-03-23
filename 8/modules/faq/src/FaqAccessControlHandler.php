<?php

declare(strict_types=1);

namespace Drupal\faq;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class FaqAccessControlHandler extends EntityAccessControlHandler
{
    protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account): AccessResult
    {
        switch ($operation) {
      case 'view':
        return AccessResult::allowedIfHasPermission($account, 'view faq');

      case 'update':
        return AccessResult::allowedIfHasPermissions($account, ['edit faq', 'administer faq'], 'OR');

      case 'delete':
        return AccessResult::allowedIfHasPermissions($account, ['delete faq', 'administer faq'], 'OR');

      default:
        return AccessResult::neutral();
    }
    }

    protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = null): AccessResult
    {
        return AccessResult::allowedIfHasPermissions($account, ['create faq', 'administer faq'], 'OR');
    }
}
