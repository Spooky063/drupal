<?php

declare(strict_types=1);

namespace Drupal\openapi_synchronization\Routing;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\ParamConverter\ParamConverterInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\Routing\Route;

final class OpenAPIParamConverter implements ParamConverterInterface
{
    public function __construct(
        private EntityTypeManagerInterface $entityManager,
    ) {
    }

    public function convert(
        $value,
        $definition,
        $name,
        array $defaults,
    ) {
        $entities = $this->entityManager->getStorage('node')->loadByProperties(
            [
                'type' => 'product',
                'field_documentation.entity:paragraph.field_apidoc_synchronization' => $value,
            ]
        );
        $entity = reset($entities);

        if ($entity instanceof NodeInterface) {
            return $entity;
        }

        return null;
    }

    public function applies(
        $definition,
        $name,
        Route $route,
    ) {
        if (!empty($definition['type']) && $definition['type'] === 'openapi.param_converter') {
            return true;
        }
        return false;
    }
}
