<?php

declare(strict_types=1);

namespace Drupal\node_list\Controller;

class NodePageRenderController
{
    public function index(): array
    {
        return [
            '#theme'    => 'node_list_render',
            '#attached' => [
                'library' => [
                    'node_list/page',
                ],
            ],
        ];
    }
}
