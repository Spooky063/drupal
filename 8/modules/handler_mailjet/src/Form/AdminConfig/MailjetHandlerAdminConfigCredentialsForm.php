<?php

declare(strict_types=1);

namespace Drupal\handler_mailjet\Form\AdminConfig;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class MailjetHandlerAdminConfigCredentialsForm extends ConfigFormBase
{
    public function getFormId(): string
    {
        return 'mailjet_settings';
    }

    public function buildForm(array $form, FormStateInterface $form_state): array
    {
        $config = $this->config('mailjet.settings');

        $form['key'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('API Key'),
            '#description'   => $this->t(''),
            '#default_value' => $config->get('key'),
            '#required'      => true,
        ];

        $form['secret'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('API Secret Key'),
            '#description'   => $this->t(''),
            '#default_value' => $config->get('secret'),
            '#required'      => true,
        ];

        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state): void
    {
        parent::submitForm($form, $form_state);

        $this->config('mailjet.settings')
            ->set('key', $form_state->getValue('key'))
            ->set('secret', $form_state->getValue('secret'))
            ->save();
    }

    protected function getEditableConfigNames(): array
    {
        return ['mailjet.settings'];
    }
}
