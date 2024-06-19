<?php

declare(strict_types=1);

namespace Drupal\openapi_synchronization\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\Routing\Route;

final class OpenAPIAccessCheck implements AccessInterface
{
    /**
     * {@inheritdoc}
     */
    public function access(
        Route $route,
        RouteMatchInterface $routeMatch,
        AccountInterface $account,
    ): AccessResult {
        /** @var ?NodeInterface $entity */
        $entity = $routeMatch->getParameter('productName');
        if ($entity instanceof NodeInterface && $entity->access("update", $account)) {
            return AccessResult::allowed();
        }

        return AccessResult::forbidden();
    }
}
