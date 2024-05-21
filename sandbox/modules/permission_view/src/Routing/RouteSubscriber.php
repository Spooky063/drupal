<?php

declare(strict_types=1);

namespace Drupal\permission_view\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

class RouteSubscriber extends RouteSubscriberBase
{
    protected function alterRoutes(RouteCollection $collection)
    {
        $routes = ['entity.node.canonical'];

        foreach ($routes as $route) {
            if ($route = $collection->get($route)) {
                $route->setRequirements(['_permission_view_access_check' => 'TRUE']);
            }
        }
    }
}
