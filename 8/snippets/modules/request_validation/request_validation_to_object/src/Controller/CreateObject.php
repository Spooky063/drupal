<?php

declare(strict_types=1);

namespace Drupal\request_validation_to_object\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\request_validation_to_object\Dto\PostDto;
use Drupal\request_validation_to_object\Form\Validator\PostFormValidator;
use Drupal\request_validation_to_object\Service\PostService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class CreateObject extends ControllerBase
{
    public function __invoke(Request $request): JsonResponse
    {
        $requestData = \json_decode((string) $request->getContent(), true);

        $form = [];

        $form_state = new FormState();
        $form_state->setMethod('POST');
        $form_state->setValues($requestData);

        $validator = new PostFormValidator();
        $validator->validateForm($form, $form_state);

        if ($form_state->hasAnyErrors()) {
            $errors = $form_state->getErrors();

            $response = ['message' => 'validation_failed', 'errors' => []];

            foreach ($errors as $property => $message) {
                if ($message instanceof TranslatableMarkup) {
                    $message = strip_tags($message->render());
                }

                $response['errors'][] = [
                'property' => $property,
                'message' => $message,
                ];
            }

            return new JsonResponse($response);
        }

        $data = PostDto::create($form_state->getValues());

        $service = new PostService($data);
        $service->saveData();

        return new JsonResponse(['message' => 'ok']);
    }
}
