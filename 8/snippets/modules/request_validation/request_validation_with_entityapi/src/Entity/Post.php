<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_entityapi\Entity;

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
class Post extends ContentEntityBase implements EntityInterface
{

    /**
     * @return FieldDefinitionInterface[]
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        $fields['name'] = BaseFieldDefinition::create('string')
            ->setLabel((new TranslatableMarkup('Name'))->render())
            ->setDescription((new TranslatableMarkup('The name of the post.'))->render())
            // I create a custom constraint just for the example
            ->addConstraint('Min', ['minValue' => 5])
            // Equals
            //->setPropertyConstraints('value', ['Length' => ['min' => 5]])
            ->setRequired(true);

        $fields['status'] = BaseFieldDefinition::create('boolean')
            ->setLabel((new TranslatableMarkup('Status'))->render())
            ->setRequired(true);

        $fields['slug'] = BaseFieldDefinition::create('string')
            ->setLabel((new TranslatableMarkup('Slug'))->render())
            ->setDescription((new TranslatableMarkup('The slug of the post.'))->render())
            ->setRequired(true);

        $fields['content'] = BaseFieldDefinition::create('text_long')
            ->setLabel((new TranslatableMarkup('Content'))->render())
            ->setDescription((new TranslatableMarkup('The content of the post.'))->render())
            ->setRequired(true);

        return $fields;
    }
}
