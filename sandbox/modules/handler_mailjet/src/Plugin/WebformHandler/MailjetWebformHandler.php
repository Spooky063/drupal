<?php

declare(strict_types=1);

namespace Drupal\handler_mailjet\Plugin\WebformHandler;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Form\FormStateInterface;
use Drupal\handler_mailjet\MailjetManagerInterface;
use Drupal\handler_mailjet\WebformMailjetManager;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\Utility\WebformOptionsHelper;
use Drupal\webform\WebformSubmissionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Send email to mailjet.
 *
 * @WebformHandler(
 *   id = "mailjet",
 *   label = @Translation("Mailjet"),
 *   category = @Translation("Notification"),
 *   description = @Translation("Sends a webform submission on Mailjet."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class MailjetWebformHandler extends WebformHandlerBase
{
    protected MailjetManagerInterface $mailjetManager;

    protected WebformMailjetManager $webformMailjetManager;

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);

        $instance->mailjetManager = $container->get('mailjet.manager');
        $instance->webformMailjetManager = $container->get('webform_mailjet.manager');

        return $instance;
    }

    public function defaultConfiguration(): array
    {
        return parent::defaultConfiguration() + [
            'mailjet_contact_list_id' => '',
            'mailjet_email_field'     => ''
        ];
    }

    public function getSummary(): array
    {
        $configuration = $this->getConfiguration();
        $settings = $configuration['settings'];

        return [
            '#theme'    => 'webform_handler_mailjet_summary',
            '#settings' => $settings,
        ] + parent::getSummary();
    }

    public function buildConfigurationForm(array $form, FormStateInterface $form_state): array
    {
        $webform = $this->getWebform();

        // Get options, mail, and text elements as options (text/value).
        $element_options = [];
        $elements = $this->webform->getElementsInitializedAndFlattened();
        foreach ($elements as $key => $element) {
            if (isset($element['#type']) && \in_array($element['#type'], ['email'], true)) {
                $title = (isset($element['#title'])) ? new FormattableMarkup('@title (@key)', ['@title' => $element['#title'], '@key' => $key]) : $key;
                $element_options[$key] = $title;
            }
        }

        $form['mailjet']['config'] = [
            '#type'  => 'details',
            '#title' => $this->t('Mailjet settings'),
            '#open'  => true,
        ];

        $contact_options = $this->mailjetManager->getContactList();
        $form['mailjet']['config']['mailjet_contact_list_id'] = [
            '#type'          => 'select',
            '#title'         => $this->t('Id of contact list'),
            '#options'       => $contact_options,
            '#required'      => true,
            '#parents'       => ['settings', 'mailjet_contact_list_id'],
            '#default_value' => $this->configuration['mailjet_contact_list_id'],
        ];

        $form['mailjet']['field'] = [
            '#type'  => 'details',
            '#title' => $this->t('Mailjet field'),
            '#open'  => true,
        ];

        $form['mailjet']['field']['mailjet_email_field'] = [
            '#type'          => 'select',
            '#title'         => $this->t('Email field'),
            '#options'       => $element_options,
            '#required'      => true,
            '#parents'       => ['settings', 'mailjet_email_field'],
            '#default_value' => $this->configuration['mailjet_email_field'],
        ];

        $form = parent::buildConfigurationForm($form, $form_state);

        return $form;
    }

    public function validateConfigurationForm(array &$form, FormStateInterface $form_state): void
    {
        parent::validateConfigurationForm($form, $form_state);

        $values = $form_state->getValues();
        $form_state->setValues($values);
    }

    public function submitConfigurationForm(array &$form, FormStateInterface $form_state): void
    {
        parent::submitConfigurationForm($form, $form_state);

        $values = $form_state->getValues();

        // Cleanup states.
        if (isset($values['states'])) {
            $values['states'] = array_values(array_filter($values['states']));
        }

        foreach ($this->configuration as $name => $value) {
            if (isset($values[$name])) {
                // Convert options array to safe config array to prevent errors.
                // @see https://www.drupal.org/node/2297311
                if (preg_match('/_options$/', $name)) {
                    $this->configuration[$name] = WebformOptionsHelper::encodeConfig($values[$name]);
                } else {
                    $this->configuration[$name] = $values[$name];
                }
            }
        }
    }

    public function postSave(WebformSubmissionInterface $webform_submission, $update = true)
    {
        $this->webformMailjetManager->subscribe($webform_submission, $this->getHandlerId());
    }
}
