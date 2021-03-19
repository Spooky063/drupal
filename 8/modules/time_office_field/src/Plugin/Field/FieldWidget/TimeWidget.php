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
 *   id = "time_widget",
 *   label = @Translation("Time widget"),
 *   field_types = {
 *     "time"
 *   }
 * )
 */
class TimeWidget extends WidgetBase
{
    public function formElement(
        FieldItemListInterface $items,
        $delta,
        array $element,
        array &$form,
        FormStateInterface $form_state
    ): array {
        // Determine if we're showing seconds in the widget.
        $show_seconds = (bool) $this->getSetting('enabled');
        $additional = [
            '#type'          => 'time',
            '#default_value' => isset($items[$delta]->value) ?
                Time::createFromTimestamp((int) $items[$delta]->value)->formatForWidget($show_seconds) :
                null,
        ];

        // Add the step attribute if we're showing seconds in the widget.
        if ($show_seconds) {
            $additional['#attributes']['step'] = $this->getSetting('step');
        }

        // Set a property to determine the format in TimeElement::preRenderTime().
        $additional['#show_seconds'] = $show_seconds;
        $element['value'] = $element + $additional;

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
