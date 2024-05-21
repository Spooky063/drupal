<?php

declare(strict_types=1);

namespace Drupal\node_list\Controller;

use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\node\NodeInterface;
use Drupal\node_list\AbstractNodeRendering;

class JsonPageController extends AbstractNodeRendering
{
    public function index(): CacheableJsonResponse
    {
        return parent::index();
    }

    public function getBundle(): string
    {
        return 'product';
    }

    public function formatNode(NodeInterface $node): array
    {
        $html = $this->entityTypeManager()->getViewBuilder('node')->view($node, 'teaser');

        return [
            // Default fields
            'nid'        => $node->id(),
            'title'      => $node->getTitle(),
            'created_at' => (int) $node->getCreatedTime(),
            'content'    => $this->rendered->renderRoot($html),
            // Custom fields
            'category' => $this->setValueSerialize('field_category', $node),
            'tags'     => $this->setValueSerialize('field_tags', $node),
        ];
    }
}
