<?php

declare(strict_types=1);

namespace Drupal\node_list\Controller;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\entity_reference_revisions\EntityReferenceRevisionsFieldItemList;
use Drupal\node\NodeInterface;
use Psr\Container\ContainerInterface;

class JsonPageController extends ControllerBase
{
    protected RendererInterface $rendered;

    private static string $bundle = 'product';

    public function __construct(RendererInterface $rendered)
    {
        $this->rendered = $rendered;
    }

    public static function create(ContainerInterface $container): self
    {
        return new static(
            $container->get('renderer')
        );
    }

    public function index(): CacheableJsonResponse
    {
        $data = $this->getData();

        $body = [
            'data'   => $data,
            'method' => 'GET',
            'status' => 200,
            '#cache' => [
                'max-age'  => -1,
                'contexts' => [
                    'request_format',
                    'url.path',
                    'languages',
                    'user.roles',
                    'user.permissions',
                ],
            ],
        ];

        if (\count($data) > 0) {
            $body['#cache']['tags'] = array_map(fn ($node) => 'node:' . $node['nid'], $data);
            $body['#cache']['tags'][] = 'node_view';
        }

        $response = new CacheableJsonResponse($body);
        $cacheMeta = new CacheableMetadata();

        if (\count($data) > 0) {
            $cacheMeta->addCacheTags($body['#cache']['tags']);
            $cacheMeta->addCacheTags(['node_list:' . self::$bundle . ':render']);
            $cacheMeta->addCacheContexts($body['#cache']['contexts']);
        }

        $response->addCacheableDependency($cacheMeta);

        return $response;
    }

    public function getData(): array
    {
        $roles = implode(':', $this->currentUser()->getRoles());
        $language = $this->languageManager()->getCurrentLanguage()->getId();

        $cached = \Drupal::cache('node_list')->get('node_list:' . self::$bundle . ':' . $language . ':' . $roles);
        if ($cached !== false) {
            /** @var string $jsonCached */
            $jsonCached = json_encode($cached);
            $arrayCached = json_decode($jsonCached, true);

            return $arrayCached['data'];
        }

        $nids = $this->entityTypeManager()->getStorage('node')
            ->getQuery()
            ->condition('type', self::$bundle)
            ->condition('status', NodeInterface::PUBLISHED)
            ->condition('langcode', $this->languageManager()->getCurrentLanguage()->getId())
            ->sort('created', 'DESC')
            ->execute();

        if (!$nids) {
            return [];
        }

        $formattedData = $this->format($nids);

        \Drupal::cache('node_list')->set(
            'node_list:' . self::$bundle . ':' . $language . ':' . $roles,
            $formattedData,
            Cache::PERMANENT,
            ['node_list:' . self::$bundle]
        );

        return $formattedData;
    }

    public function format(array $nids): array
    {
        $result = [];
        foreach ($nids as $nid) {
            $node = $this->entityTypeManager()->getStorage('node')->load($nid);

            if (!$node instanceof NodeInterface) {
                throw new \Exception('Error to get node.');
            }

            $html = $this->entityTypeManager()->getViewBuilder('node')->view($node, 'teaser');

            $result[] = [
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

        return $result;
    }

    /**
     * @return mixed
     */
    private function setValueSerialize(string $field_name, NodeInterface $node)
    {
        if (!$node->hasField($field_name)) {
            return null;
        }

        $definition = $node->get($field_name)->getFieldDefinition()->getFieldStorageDefinition();

        if ($definition->getType() === 'entity_reference') {
            /** @var EntityReferenceRevisionsFieldItemList $field */
            $field = $node->get($field_name);
            $entities = $field->referencedEntities();
            /* @var array<string> $value */
            return array_map(function (EntityInterface $entity) {
                return $entity->label();
            }, $entities);
        }

        if (\in_array($definition->getType(), ['string', 'text_long'], true)) {
            return $node->{$field_name}->value;
        }

        if ($definition->getType() === 'datetime') {
            return $node->get($field_name)->getString();
        }
    }
}
