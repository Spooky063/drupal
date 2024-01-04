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
        $entities = $articleStorage->getAllArticles();

        dump($entities);

        return new Response('ok');
    }
}
