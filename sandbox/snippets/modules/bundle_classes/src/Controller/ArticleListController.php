<?php

declare(strict_types=1);

namespace Drupal\bundle_classes\Controller;

use Drupal\Core\Controller\ControllerBase;

class ArticleListController extends ControllerBase
{
    public function __invoke(): array
    {
        $articleList = $this->entityTypeManager()->getStorage('node')->loadMultiple();

        return [
        '#theme' => 'article',
        '#nodes' => $articleList,
        ];
    }
}
