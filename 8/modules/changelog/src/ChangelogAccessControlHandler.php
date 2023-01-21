<?php

declare(strict_types=1);

namespace Drupal\changelog;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

class ChangelogAccessControlHandler extends EntityAccessControlHandler
{
  protected function checkAccess(
    EntityInterface $entity,
    $operation,
    AccountInterface $account
  ): AccessResult
  {
    return match ($operation) {
      'view', 'update', 'delete' => AccessResult::allowed(),
      default => AccessResult::neutral(),
    };
  }

  protected function checkCreateAccess(
    AccountInterface $account,
    array $context,
    $entity_bundle = null
  ): AccessResult
  {
    return AccessResult::allowed();
  }

}
