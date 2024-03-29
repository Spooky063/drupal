<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_formapi\Form\Validator;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

class PostFormValidator
{
    public function validateForm(array &$form, FormStateInterface $form_state): void
    {
        $datas = $form_state->getValues();

        $notNullMessage = new TranslatableMarkup('This value should not be null.');

        if (empty($datas['name'])) {
            $form_state->setErrorByName('name', $notNullMessage->render());
        } elseif  (\strlen($datas['name']) <= 5) {
            $lengthMinMessage = new TranslatableMarkup(
                '%value must be greater than 5 characters',
                ['%value' => $datas['name']]
            );
            $form_state->setErrorByName('name', $lengthMinMessage->render());
        }

        if (!isset($datas['status']) || (string) $datas['status'] === "") {
            $form_state->setErrorByName('status', $notNullMessage->render());
        } elseif  (!in_array((int) $datas['status'], [0, 1], true)) {
            $outOfRangeMessage = new TranslatableMarkup(
                '%value must be equal to 0 or 1',
                ['%value' => $datas['status']]
            );
            $form_state->setErrorByName('status', $outOfRangeMessage->render());
        }

        if (empty($datas['slug'])) {
            $form_state->setErrorByName('slug', $notNullMessage->render());
        }

        if (empty($datas['content'])) {
            $form_state->setErrorByName('content', $notNullMessage->render());
        }
    }
}
