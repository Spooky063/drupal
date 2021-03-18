<?php

declare(strict_types=1);

namespace Drupal\entity_alias_taxonomy_demo\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\taxonomy\TermInterface;

class BasicPageController extends ControllerBase implements ContainerInjectionInterface
{
    public function index(TermInterface $taxonomy_term): array
    {
        return [
            '#markup' => "You are in taxonomy term {$taxonomy_term->getName()}"
        ];
    }

    public function getTitle(TermInterface $taxonomy_term): string
    {
        return $taxonomy_term->getName();
    }
}
