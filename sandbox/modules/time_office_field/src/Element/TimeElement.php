<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Element;

use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element;
use Drupal\Core\Render\Element\FormElement;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\time_office_field\Time;

/**
 * Provides a time field form element.
 *
 * @FormElement("time")
 */
class TimeElement extends FormElement
{
    public function getInfo(): array
    {
        $class = \get_class($this);

        return [
            '#show_seconds' => false,
            '#input'        => true,
            '#pre_render'   => [
                [$class, 'preRenderTime'],
            ],
            '#theme'            => 'input__time',
            '#theme_wrappers'   => ['form_element'],
            '#element_validate' => [
                [$class, 'validateOfficeHoursSlot'],
            ],
        ];
    }

    /**
     * Return value formatted.
     *
     * @param  array          $element
     * @param  mixed          $input
     * @return int|mixed|null
     */
    public static function valueCallback(&$element, $input, FormStateInterface $form_state)
    {
        if (isset($element['#default_value']) && $element['#default_value'] !== null && $input === false) {
            $input = $element['#default_value'];
        }

        if ($input !== false) {
            $time = Time::createFromHtml5Format($input);

            return $time->getTimestamp();
        }

        return null;
    }

    /**
     * Prepares a #type 'time' render element for input.html.twig.
     *
     * @param array $element
     *                       An associative array containing the properties of the element.
     *                       Properties used: #title, #value, #description, #size, #maxlength,
     *                       #placeholder, #required, #attributes.
     *
     * @return array
     *               The $element with prepared variables ready for input.html.twig.
     *
     * @see \Drupal\time_office_field\Plugin\Field\FieldWidget\TimeWidget::formElement()
     */
    public static function preRenderTime(array $element): array
    {
        $element['#attributes']['type'] = 'time';
        $element['#attributes']['class'] = ['form-time'];

        // In ajax request value is set to raw timestamp perform a better solution here.
        $isValuePassedInTimestampFormat = preg_match('/^\d+$/', (string) $element['#value']);
        if ($isValuePassedInTimestampFormat !== false) {
            $element['#value'] = Time::createFromTimestamp((int) $element['#value'])
                ->formatForWidget($element['#show_seconds']);
        } else {
            $element['#value'] = null;
        }

        Element::setAttributes($element, [
            'id',
            'name',
            'value',
            'size',
            'maxlength',
            'placeholder',
        ]);
        static::setAttributes($element, ['form-text']);

        return $element;
    }

    public static function validateOfficeHoursSlot(array &$element, FormStateInterface $form_state): void
    {
        $error_text = null;

        $values = $form_state->getValues();

        array_pop($element['#parents']);
        $input = NestedArray::getValue($values, $element['#parents'], $input_exists);

        $firstElement = reset($element['#parents']);
        $inputs = NestedArray::getValue($values, [$firstElement], $input_exists);

        $start = $input['from'] ?? '';
        $end = $input['to'] ?? '';

        if ($inputs !== null) {
            $length = \count($inputs);
            if ($length > 1) {
                for ($i = 1; $i < $length; $i++) {
                    if (isset($inputs[$i]) && isset($inputs[$i]['from'])) {
                        if ($inputs[$i]['from'] !== null && $inputs[$i - 1]['to'] > $inputs[$i]['from']) {
                            $error_text = (string) new TranslatableMarkup('Time range can not overlap.');
                        }
                    }
                }
            }
        }
        if ($input !== null) {
            if ($start > $end) {
                $error_text = (string) new TranslatableMarkup('Closing hours are earlier than Opening hours.');
            }
        }

        if ($error_text !== null) {
            $form_state->setError($element, $error_text);
        }
    }
}
