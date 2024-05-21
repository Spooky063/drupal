<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_typeddataapi\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\request_validation_with_typeddataapi\Plugin\DataType\PostData;
use Drupal\request_validation_with_typeddataapi\TypedData\Definition\PostDefinition;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateObjectWithTypedDataApi extends ControllerBase
{
    public function __invoke(Request $request): JsonResponse
    {
        $requestData = \json_decode((string) $request->getContent(), true);

        $postDefinition = PostDefinition::create('post_response');
        /** @var PostData $postData */
        $postData = \Drupal::typedDataManager()->create($postDefinition);
        $postData->setValue($requestData);

        $violations = $postData->validate();

        if (count($violations) > 0) {
          $response = ['message' => 'validation_failed', 'errors' => []];

          foreach ($violations as $violation) {
              $message = $violation->getMessage();
              if ($message instanceof TranslatableMarkup) {
                  $message = strip_tags($message->render());
              }

              $response['errors'][] = [
              'property' => $violation->getPropertyPath(),
              'message' => $message,
              ];
          }

          return new JsonResponse($response);
        }

        // $values = [
        //   'name' => $postData->get('name')->getValue(),
        //   'status' => $postData->get('status')->getValue(),
        //   'slug' => $postData->get('slug')->getValue(),
        //   'content' => $postData->get('content')->getValue(),
        // ];

        return new JsonResponse(['message' => 'ok']);
    }
}
