<?php

declare(strict_types=1);

namespace Drupal\openapi_synchronization\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\FileInterface;
use Drupal\node\NodeInterface;
use Drupal\openapi_synchronization\OpenAPISpecificationFileManager;
use Drupal\openapi_synchronization\OpenAPISpecificationProductManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class OpenAPISpecification extends ControllerBase
{
    public function __construct(
        private OpenAPISpecificationFileManager $fileManager,
        private OpenAPISpecificationProductManager $productManager,
    ) {
    }

    public static function create(
        ContainerInterface $container,
    ): self {
        return new static(
            $container->get('openapi.filemanager'),
            $container->get('openapi.productmanager'),
        );
    }

    public function update(
        Request $request,
    ): JsonResponse {
        $file = $this->fileManager->save($request);
        if (!($file instanceof FileInterface)) {
            return new JsonResponse($file, 400, []);
        }

        /** @var NodeInterface $entity */
        $entity = $request->attributes->get('productName');
        $currentFile = $this->productManager->getOpenAPIFileFromEntity($entity);
        $errors = $this->productManager->updateOpenAPIFileFromEntity($entity, $file);
        if (!empty($errors)) {
            $this->fileManager->remove($file);
            return new JsonResponse($errors, 422, []);
        }

        if ($currentFile) {
            $this->fileManager->remove($currentFile);
        }
        return new JsonResponse('', 204, []);
    }
}
