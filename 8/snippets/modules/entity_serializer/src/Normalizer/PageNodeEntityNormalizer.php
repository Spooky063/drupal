<?php

declare(strict_types=1);

namespace Drupal\entity_serializer\Normalizer;

use Drupal\node\NodeInterface;
use Drupal\serialization\Normalizer\ContentEntityNormalizer;

final class NodeEntityNormalizer extends ContentEntityNormalizer
{
  protected $supportedInterfaceOrClass = 'Drupal\node\NodeInterface';

  public function supportsNormalization($data, $format = null): bool
  {
    if (!is_object($data) || !$this->checkFormat($format)) {
      return false;
    }
    if ($data instanceof NodeInterface && $data->getType() === 'page') {
      return true;
    }

    return false;
  }

  /**
   * @param NodeInterface $entity
   */
  public function normalize($entity, $format = null, array $context = array()): array
  {
    $data = parent::normalize($entity, $format, $context);

    $data = [
      'title' => $entity->getTitle(),
    ];

    return $data;
  }
}
