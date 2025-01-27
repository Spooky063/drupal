<?php

declare(strict_types=1);

namespace Drupal\access\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;

final class SeePageAccess implements AccessInterface
{
    public function access(AccountInterface $account): AccessResult
    {
        return $account->hasPermission('see page')
        ? AccessResult::allowed()->cachePerUser()
        : AccessResult::forbidden()->cachePerUser()
        ;
    }
}
