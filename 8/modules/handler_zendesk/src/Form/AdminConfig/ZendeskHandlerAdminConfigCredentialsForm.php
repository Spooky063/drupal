<?php

declare(strict_types=1);

namespace Drupal\handler_zendesk\Form\AdminConfig;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ZendeskHandlerAdminConfigCredentialsForm extends ConfigFormBase
{
    public function getFormId(): string
    {
        return 'zendesk_settings';
    }

    public function buildForm(array $form, FormStateInterface $form_state): array
    {
        $config = $this->config('zendesk.settings');

        $form['subdomain'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('Subdomain'),
            '#default_value' => $config->get('subdomain'),
            '#field_suffix'  => '.zendesk.com',
            '#required'      => true,
        ];

        $form['username'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('Username'),
            '#description'   => $this->t('Email address to connect to zendesk dashboard'),
            '#default_value' => $config->get('username'),
            '#required'      => true,
        ];

        $form['token'] = [
            '#type'          => 'textfield',
            '#title'         => $this->t('Token'),
            '#default_value' => $config->get('token'),
            '#required'      => true,
        ];

        return parent::buildForm($form, $form_state);
    }

    public function submitForm(array &$form, FormStateInterface $form_state): void
    {
        parent::submitForm($form, $form_state);

        $this->config('zendesk.settings')
            ->set('subdomain', $form_state->getValue('subdomain'))
            ->set('username', $form_state->getValue('username'))
            ->set('token', $form_state->getValue('token'))
            ->save();
    }

    protected function getEditableConfigNames(): array
    {
        return ['zendesk.settings'];
    }
}
