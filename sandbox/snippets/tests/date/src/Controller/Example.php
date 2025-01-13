<?php

declare(strict_types=1);

namespace Drupal\date\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\date\Action\GetBasicPageNode;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Example extends ControllerBase implements ContainerInjectionInterface
{

  private GetBasicPageNode $action;

  public function __construct(
    GetBasicPageNode $action,
  ) {
    $this->action = $action;
  }

  public static function create(ContainerInterface $container): self
  {
    return new static(
      $container->get('date.basic_page_node_action'),
    );
  }

  public function index(): JsonResponse
  {
    $nodes = $this->action->execute();

    $presenter = [];
    foreach ($nodes as $node) {
      $presenter[] = [
        'id' => $node->id(),
        'title' => $node->label(),
        'created' => date('Y-m-d H:i:s', (int) $node->getCreatedTime()),
      ];
    }

    return new JsonResponse($presenter);
  }
}
