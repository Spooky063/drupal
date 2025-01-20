<?php

declare(strict_types=1);

namespace Drupal\events\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\events\DataService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @codeCoverageIgnore
 */
final class DataController extends ControllerBase implements ContainerInjectionInterface
{
    public function __construct(
        private readonly DataService $dataService,
    ) {
    }

    public static function create(
        ContainerInterface $container,
    ): self {
        return new self(
            $container->get('events.data_service'),
        );
    }

    public function index(): JsonResponse
    {
        $response = $this->dataService->execute();

        return new JsonResponse($response);
    }
}
