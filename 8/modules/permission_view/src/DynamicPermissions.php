<?php

declare(strict_types=1);

namespace Drupal\permission_view;

use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\node\Entity\NodeType;
use Drupal\taxonomy\Entity\Vocabulary;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DynamicPermissions implements ContainerInjectionInterface
{
    protected EntityTypeManagerInterface $entityTypeManager;

    public function __construct(EntityTypeManagerInterface $entityTypeManager)
    {
        $this->entityTypeManager = $entityTypeManager;
    }

    public static function create(ContainerInterface $container): self
    {
        return new static(
            $container->get('entity_type.manager')
        );
    }

    public function permissions(): array
    {
        $permissions = [];

        /** @var array<Vocabulary> $taxonomies */
        $taxonomies = $this->entityTypeManager->getStorage('taxonomy_vocabulary')->loadMultiple();
        foreach ($taxonomies as $taxonomy) {
            $permissions += [
                'permission_view_taxonomy_' . $taxonomy->id() => [
                    'title'           => new TranslatableMarkup(
                        'Taxonomy - @name : See canonical page',
                        ['@name' => $taxonomy->get('name')]
                    ),
                    'restrict access' => false,
                ],
            ];
        }

        /** @var array<NodeType> $nodeTypes */
        $nodeTypes = $this->entityTypeManager->getStorage('node_type')->loadMultiple();
        foreach ($nodeTypes as $name => $nodeType) {
            $permissions += [
                'permission_view_node_' . $name => [
                    'title'           => new TranslatableMarkup(
                        'Node - @name : See canonical page',
                        ['@name' => $nodeType->get('name')]
                    ),
                    'restrict access' => false,
                ],
            ];
        }

        return $permissions;
    }
}
