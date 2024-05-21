<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\time_office_field\Time;

/**
 * Plugin implementation of the 'time_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "time_formatter",
 *   label = @Translation("Time formatter"),
 *   field_types = {
 *     "time"
 *   }
 * )
 */
class TimeFormatter extends FormatterBase
{
    public function viewElements(FieldItemListInterface $items, $langcode): array
    {
        $elements = [];

        foreach ($items as $delta => $item) {
            $viewValue = $this->viewValue($item);
            if (null !== $viewValue) {
                $elements[$delta] = ['#markup' => $viewValue];
            }
        }

        return $elements;
    }

    public function settingsForm(array $form, FormStateInterface $form_state): array
    {
        $elements = parent::settingsForm($form, $form_state);
        $elements['time_format'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('Time Format'),
            '#default_value' => (string) $this->getSetting('time_format'),
            '#description'   => $this->getTimeDescription(),
        ];

        return $elements;
    }

    public static function defaultSettings(): array
    {
        return [
            'time_format' => 'h:i a',
        ] + parent::defaultSettings();
    }

    protected function viewValue(FieldItemInterface $item): ?string
    {
        $time = isset($item->value) ? Time::createFromTimestamp((int) $item->value) : null;

        if ($time === null) {
            throw new \InvalidArgumentException('Time parameter is not set');
        }

        if (
            $time->getHour() === 0 &&
            $time->getMinute() === 0 &&
            $time->getSecond() === 0
        ) {
            return null;
        }

        return $time->format($this->getSetting('time_format'));
    }

    private function getTimeDescription(): string
    {
        $output = '';
        $output .= $this->t('a - Lowercase am or pm') . '<br/>';
        $output .= $this->t('A - Uppercase AM or PM') . '<br/>';
        $output .= $this->t('B - Swatch Internet time (000 to 999)') . '<br/>';
        $output .= $this->t('g - 12-hour format of an hour (1 to 12)') . '<br/>';
        $output .= $this->t('G - 24-hour format of an hour (0 to 23)') . '<br/>';
        $output .= $this->t('h - 12-hour format of an hour (01 to 12)') . '<br/>';
        $output .= $this->t('H - 24-hour format of an hour (00 to 23)') . '<br/>';
        $output .= $this->t('i - Minutes with leading zeros (00 to 59)') . '<br/>';
        $output .= $this->t('s - Seconds, with leading zeros (00 to 59)') . '<br/>';

        return $output;
    }
}
