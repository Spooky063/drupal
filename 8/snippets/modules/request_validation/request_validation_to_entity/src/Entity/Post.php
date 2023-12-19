<?php

namespace Drupal\request_validation_to_entity\Entity;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * @ContentEntityType(
 *   id = "post",
 *   label = @Translation("Post"),
 *   base_table = "post",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *   }
 * )
 */
class Post extends ContentEntityBase implements EntityInterface {

  /**
   * @return FieldDefinitionInterface[]
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
  {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Name'))
      ->setDescription(new TranslatableMarkup('The name of the post.'))
      ->addConstraint('Min', ['minValue' => 5])
      ->setRequired(TRUE);

    $fields['slug'] = BaseFieldDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Slug'))
      ->setDescription(new TranslatableMarkup('The slug of the post.'))
      ->setRequired(TRUE);

    $fields['content'] = BaseFieldDefinition::create('text_long')
      ->setLabel(new TranslatableMarkup('Content'))
      ->setDescription(new TranslatableMarkup('The content of the post.'))
      ->setRequired(TRUE);

    return $fields;
  }
}
