<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_jsonschema\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\request_validation_with_jsonschema\Dto\PostDto;
use Drupal\request_validation_with_jsonschema\Entity\Post;
use Drupal\request_validation_with_jsonschema\Validator\PostCreateSchema;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateObjectWithJsonSchema extends ControllerBase
{
    public function __invoke(Request $request): JsonResponse
    {
        $requestData = \json_decode((string) $request->getContent());

        $validator = new Validator();
        $validator->validate(
            $requestData,
            json_decode((new PostCreateSchema())->getSchema()),
            Constraint::CHECK_MODE_COERCE_TYPES
        );

        if (!$validator->isValid()) {
            $response = ['message' => 'validation_failed', 'errors' => []];

            foreach ($validator->getErrors() as $error) {
                $response['errors'][] = [
                  'property' => $error['property'],
                  'message' => $error['message'],
                ];
            }

            return new JsonResponse($response);
        }

        return new JsonResponse(['message' => 'ok']);
    }
}
