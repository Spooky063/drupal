<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'time' field type.
 *
 * @FieldType(
 *   category= @Translation("General"),
 *   id = "time",
 *   label = @Translation("Time"),
 *   description = @Translation("Time field"),
 *   default_widget = "time_widget",
 *   default_formatter = "time_formatter"
 * )
 */
class TimeType extends FieldItemBase
{
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array
    {
        $properties = [];

        $properties['value'] = DataDefinition::create('integer')
            ->setLabel((string) new TranslatableMarkup('Seconds passed through midnight'))
            ->setSetting('unsigned', true)
            ->setSetting('size', 'small')
            ->setRequired(true);

        return $properties;
    }

    public static function schema(FieldStorageDefinitionInterface $field_definition): array
    {
        return [
            'columns' => [
                'value' => [
                    'type'   => 'int',
                    'length' => 6,
                ],
            ],
            'indexes' => [
                'value' => ['value'],
            ],
        ];
    }

    public function getConstraints(): array
    {
        $constraints = parent::getConstraints();

        $constraint_manager = \Drupal::typedDataManager()
            ->getValidationConstraintManager();

        $constraints[] = $constraint_manager->create('ComplexData', [
            'value' => ['time' => []],
        ]);

        return $constraints;
    }

    public static function generateSampleValue(FieldDefinitionInterface $field_definition): array
    {
        $values = parent::generateSampleValue($field_definition);

        $values['value'] = 0;

        return $values;
    }

    public function isEmpty(): bool
    {
        $value = $this->get('value')->getValue();

        if ($value === null || $value === 0) {
            return true;
        }

        return false;
    }
}
