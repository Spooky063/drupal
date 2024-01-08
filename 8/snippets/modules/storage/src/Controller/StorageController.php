<?php

declare(strict_types=1);

namespace Drupal\storage\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\storage\ArticleStorage;
use Symfony\Component\HttpFoundation\Response;

class StorageController extends ControllerBase
{
    public function __invoke(): Response
    {
        /**
         * @var ArticleStorage $articleStorage
        */
        $articleStorage = $this->entityTypeManager()->getStorage('node');
        $publishedEntities = $articleStorage->getPublishedArticles();
        $countPublishedEntities = $articleStorage->countPublishedArticles();
        $publishedEntitiesWithTags = $articleStorage->getPublishedArticlesWithSpecificTags(['article']);
        $countEntities = $articleStorage->countArticles();

        dump($countEntities, $countPublishedEntities, $publishedEntities, $publishedEntitiesWithTags);

        return new Response('ok');
    }
}
