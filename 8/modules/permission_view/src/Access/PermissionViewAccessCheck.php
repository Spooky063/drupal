<?php

declare(strict_types=1);

namespace Drupal\permission_view\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;

class PermissionViewAccessCheck implements AccessInterface
{
    protected EntityTypeManagerInterface $entityTypeManager;

    public function __construct(EntityTypeManagerInterface $entity_type_manager)
    {
        $this->entityTypeManager = $entity_type_manager;
    }

    public function access(AccountInterface $account, RouteMatchInterface $routeMatch): AccessResult
    {
        if ($routeMatch->getRouteName() === 'entity.node.canonical') {
            $bundle = $routeMatch->getParameter('node')->bundle();

            return AccessResult::allowedIfHasPermission($account, "permission_view_node_{$bundle}");
        }
    }
}
