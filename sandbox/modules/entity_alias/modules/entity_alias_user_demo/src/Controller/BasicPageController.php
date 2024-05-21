<?php

declare(strict_types=1);

namespace Drupal\entity_alias_user_demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\user\Entity\User;

class BasicPageController extends ControllerBase implements ContainerInjectionInterface
{
    public function index(User $user): array
    {
        return [
            '#markup' => "You are user {$user->getDisplayName()}"
        ];
    }

    public function getTitle(User $user): string
    {
        return (string) $user->getDisplayName();
    }
}
