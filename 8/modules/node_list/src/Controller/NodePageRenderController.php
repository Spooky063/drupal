<?php

declare(strict_types=1);

namespace Drupal\node_list\Controller;

use Drupal\Core\Url;

class NodePageRenderController
{
    public function index(): array
    {
        return [
            '#theme'    => 'node_list_render',
            '#endpoint' => Url::fromRoute('node_list.article')->toString(),
            '#pagination' => 10,
            '#attached' => [
                'library' => [
                    'node_list/page',
                ],
            ],
        ];
    }
}
