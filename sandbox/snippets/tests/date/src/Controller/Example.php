<?php

declare(strict_types=1);

namespace Drupal\date\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\date\Action\GetBasicPageNode;
use Drupal\date\Presenter\BasicPageNodeArrayPresenter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

final class Example extends ControllerBase implements ContainerInjectionInterface
{
    public function __construct(
      private readonly GetBasicPageNode $action
    ) {
    }

    public static function create(ContainerInterface $container): self
    {
        return new self(
            $container->get('date.basic_page_node_action'),
        );
    }

    public function index(): JsonResponse
    {
        $nodes = $this->action->execute();

        $presenter = new BasicPageNodeArrayPresenter($nodes);

        return new JsonResponse($presenter->present());
    }
}
