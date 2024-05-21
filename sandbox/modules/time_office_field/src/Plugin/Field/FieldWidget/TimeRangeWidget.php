<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\time_office_field\Time;

/**
 * Plugin implementation of the 'time_widget' widget.
 *
 * @FieldWidget(
 *   id = "time_range_widget",
 *   label = @Translation("Time range widget"),
 *   field_types = {
 *     "time_range"
 *   }
 * )
 */
class TimeRangeWidget extends WidgetBase
{
    public function formElement(
        FieldItemListInterface $items,
        $delta,
        array $element,
        array &$form,
        FormStateInterface $form_state
    ): array {
        $element['from'] = [
            '#title' => $this->t('Start time'),
            '#type'  => 'time',
        ];
        $element['to'] = [
            '#title' => $this->t('End time'),
            '#type'  => 'time',
        ];

        if (is_numeric($items[$delta]->from)) {
            $element['from']['#default_value'] = isset($items[$delta]->from) ?
                Time::createFromTimestamp((int) $items[$delta]->from)->formatForWidget() :
                null;
        }

        if (is_numeric($items[$delta]->to)) {
            $element['to']['#default_value'] = isset($items[$delta]->to) ?
                Time::createFromTimestamp((int) $items[$delta]->to)->formatForWidget() :
                null;
        }

        if ($this->fieldDefinition->getFieldStorageDefinition()->getCardinality() === 1) {
            $element += [
                '#type' => 'fieldset',
            ];
        }

        $show_seconds = (bool) $this->getSetting('enabled');
        if ($show_seconds) {
            $element['from']['#attributes']['step'] = $this->getSetting('step');
            $element['to']['#attributes']['step'] = $this->getSetting('step');
        }

        $element['from']['#show_seconds'] = $show_seconds;
        $element['to']['#show_seconds'] = $show_seconds;

        $element['#attached'] = [
            'library' => [
                'time_office_field/time_office_field_formatter',
            ],
        ];

        return $element;
    }

    public static function defaultSettings(): array
    {
        return [
            'enabled' => false,
            'step'    => 5,
        ] + parent::defaultSettings();
    }

    public function settingsForm(array $form, FormStateInterface $form_state): array
    {
        return [
            'enabled' => [
                '#type'          => 'checkbox',
                '#title'         => $this->t('Add seconds parameter to input widget'),
                '#default_value' => $this->getSetting('enabled'),
            ],
            'step' => [
                '#type'          => 'textfield',
                '#title'         => $this->t('Step to change seconds'),
                '#open'          => true,
                '#default_value' => $this->getSetting('step'),
                '#states'        => [
                    'visible' => [
                        ':input[name$="[enabled]"]' => ['checked' => true],
                    ],
                ],
            ],
        ] + parent::settingsForm($form, $form_state);
    }
}
