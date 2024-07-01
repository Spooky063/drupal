<?php

declare(strict_types=1);

namespace Drupal\dynamic_relative_date\Plugin\Field\FieldFormatter;

use DateTime;
use DateTimezone;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeFieldItemList;

/**
 * Plugin implementation of the 'relative_dates' formatter.
 *
 * @FieldFormatter(
 *   id = "relative_dates",
 *   label = @Translation("Relative dates"),
 *   field_types = {
 *     "datetime"
 *   }
 * )
 */
class DynamicRelativeDateFormatter extends FormatterBase
{
    /**
     * @param DateTimeFieldItemList $items
     * @return array<int|string, mixed>
     * @throws \Exception
     */
    public function viewElements(FieldItemListInterface $items, $langcode): array
    {
        $elements = [];

        foreach ($items as $delta => $item) {
            $date = new DateTime($item->value ?? '', new DateTimeZone('UTC'));

            $elements[$delta] = [
            '#type' => 'html_tag',
            '#tag' => 'time',
            '#attributes' => [
            'class' => ['dynamic-relative-time'],
            'datetime' => $date->format('c')
            ],
            '#value' => $date->format('Y-m-d H:i:s'),
            ];
        }

        $elements['#attached']['library'][] = 'dynamic_relative_date/relative_dates';

        return $elements;
    }
}
