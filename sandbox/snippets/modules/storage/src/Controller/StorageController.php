<?php

declare(strict_types=1);

namespace Drupal\storage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\storage\ArticleStorage;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class StorageController extends ControllerBase implements ContainerInjectionInterface
{
    public function __construct(private string $entity_type)
    {

    }

    public static function create(ContainerInterface $container): self
    {
      return new self(
        $container->getParameter('entity_type')
      );
    }

    public function __invoke(): Response
    {
        /**
         * @var ArticleStorage $articleStorage
        */
        $articleStorage = $this->entityTypeManager()->getStorage($this->entity_type);
        $publishedEntities = $articleStorage->getPublishedArticles();
        $countPublishedEntities = $articleStorage->countPublishedArticles();
        $publishedEntitiesWithTags = $articleStorage->getPublishedArticlesWithSpecificTags(['article']);
        $countEntities = $articleStorage->countArticles();

        dump($countEntities, $countPublishedEntities, $publishedEntities, $publishedEntitiesWithTags);

        return new Response('ok');
    }
}
