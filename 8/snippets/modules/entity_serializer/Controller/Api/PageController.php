<?php

declare(strict_types=1);

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Serializer\SerializerInterface;

namespace Drupal\entity_serializer\Controller\Api;

final class PageController extends ControllerBase implements ContainerInjectionInterface
{
  public function __construct(private SerializerInterface $serializer)
  {
  }

  public static function create(ContainerInterface $container): self
  {
    return new self(
      $container->get('serializer'),
    );
  }

  public function __invoke(): CacheableJsonResponse
  {
    $nodes = $this->entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page']);

    $normalizedNodes = [];
    foreach ($nodes as $node) {
      $normalizedNodes[] = json_decode($this->serializer->serialize($node, 'json'), true);
    }

    $cacheMetadatas = [
      '#cache' => [
          'tags' => ['node_list:page'],
      ]
    ];

    $response = new CacheableJsonResponse($normalizedNodes, 200);
    $response->addCacheableDependency(CacheableMetadata::createFromRenderArray($cacheMetadatas));
    return $response;
  }
}