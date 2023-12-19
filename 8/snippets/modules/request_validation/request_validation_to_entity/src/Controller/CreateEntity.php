<?php

declare(strict_types=1);

namespace Drupal\request_validation_to_entity\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\request_validation_to_entity\Entity\Post;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class CreateEntity extends ControllerBase implements ContainerInjectionInterface
{
  protected SerializerInterface $serializer;

  public function __construct(SerializerInterface $serializer)
  {
    $this->serializer = $serializer;
  }

  public static function create(ContainerInterface $container): self
  {
    return new self(
      $container->get('serializer'),
    );
  }

  public function __invoke(Request $request): JsonResponse
  {
    /** @var Post $post */
    $post = $this->serializer->deserialize($request->getContent(), Post::class, 'json');

    $violations = $post->validate();

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

    return new JsonResponse(['message' => 'ok']);
  }
}
