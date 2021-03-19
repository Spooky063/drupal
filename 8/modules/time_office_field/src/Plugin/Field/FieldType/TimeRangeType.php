<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'time' field type.
 *
 * @FieldType(
 *   category= @Translation("General"),
 *   id = "time_range",
 *   label = @Translation("Time Range"),
 *   description = @Translation("Time range field"),
 *   default_widget = "time_range_widget",
 *   default_formatter = "time_range_formatter"
 * )
 */
class TimeRangeType extends FieldItemBase
{
    public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition): array
    {
        $properties = [];

        $properties['from'] = DataDefinition::create('integer')
            ->setLabel((string) new TranslatableMarkup('Seconds passed through midnight'))
            ->setSetting('unsigned', true)
            ->setSetting('size', 'small')
            ->setRequired(true);

        $properties['to'] = DataDefinition::create('integer')
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
                'from' => [
                    'type'   => 'int',
                    'length' => 6,
                ],
                'to' => [
                    'type'   => 'int',
                    'length' => 6,
                ],
            ],
            'indexes' => [
                'value' => ['from', 'to'],
            ],
        ];
    }

    public function isEmpty(): bool
    {
        $from = $this->get('from')->getValue();
        $to = $this->get('to')->getValue();

        if (($from === null || $from === 0) || ($to === null || $to === 0)) {
            return true;
        }

        return false;
    }
}
