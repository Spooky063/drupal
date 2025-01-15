<?php

declare(strict_types=1);

namespace Drupal\form\Form\Admin;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

final class NewsletterForm extends ConfigFormBase
{
    public const CONFIG_NAME = 'newsletter.settings';

    public function getFormId(): string
    {
        return str_replace('.', '_', self::CONFIG_NAME);
    }

    /**
     * @return string[]
     */
    public function getEditableConfigNames(): array
    {
        return [static::CONFIG_NAME];
    }

    /**
     * @inheritdoc
     * @phpstan-ignore-next-line
     */
    public function buildForm(
        array $form,
        FormStateInterface $form_state
    ): array {
        $config = $this->config(static::CONFIG_NAME);

        $form['email'] = [
        '#type' => 'email',
        '#title' => $this->t('Email Address'),
        '#description' => $this->t('Enter a valid email address. <em>Disposable email address are not allowed.<em>'),
        '#default_value' => $config->get('email'),
        '#required' => true,
        ];

        $form['color'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Color'),
        '#description' => $this->t('Enter a valid color in hexadecimal format, e.g., #ffffff.'),
        '#default_value' => $config->get('color'),
        '#required' => true,
        ];

        return parent::buildForm($form, $form_state);
    }

    /**
     * @inheritdoc
     * @phpstan-ignore-next-line
     */
    public function validateForm(
        array &$form,
        FormStateInterface $form_state
    ): void {
        parent::validateForm($form, $form_state);

        $email = $form_state->getValue('email');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $form_state->setErrorByName('email', $this->t('The email address is not valid.')->render());
            return;
        }

        $disposable_domains = ['yopmail.com', 'mailinator.com', 'trashmail.com'];
        [$_, $domain] = explode('@', (string) $email);
        if (in_array($domain, $disposable_domains, true)) {
            $form_state->setErrorByName('email', $this->t('Disposable email addresses are not allowed.')->render());
        }

        $color = $form_state->getValue('color');
        if (!preg_match('/^#[0-9a-fA-F]{3,6}$/', (string) $color)) {
            $form_state->setErrorByName(
                'color',
                $this->t('The color must be in hexadecimal format, starting with #.')->render()
            );
        }
    }

    /**
     * @inheritdoc
     * @phpstan-ignore-next-line
     */
    public function submitForm(
        array &$form,
        FormStateInterface $form_state
    ): void {
        $config = $this->configFactory->getEditable(static::CONFIG_NAME);
        $config->set('email', $form_state->getValue('email'));
        $config->set('color', $form_state->getValue('color'));
        $config->save();

        \Drupal::moduleHandler()->invoke('form', 'send_newsletter_email', [$form_state->getValue('email')]);

        parent::submitForm($form, $form_state);
    }
}
