<?php

declare(strict_types=1);

namespace Drupal\handler_zendesk\Plugin\WebformHandler;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Core\Form\FormStateInterface;
use Drupal\handler_zendesk\Entity\Contact;
use Drupal\handler_zendesk\Zendesk\ZendeskWrapperInterface;
use Drupal\webform\Plugin\WebformHandlerBase;
use Drupal\webform\Utility\WebformOptionsHelper;
use Drupal\webform\WebformSubmissionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Send email to create zendesk ticket.
 *
 * @WebformHandler(
 *   id = "zendesk",
 *   label = @Translation("Zendesk"),
 *   category = @Translation("Notification"),
 *   description = @Translation("Sends a webform submission on Zendesk."),
 *   cardinality = \Drupal\webform\Plugin\WebformHandlerInterface::CARDINALITY_UNLIMITED,
 *   results = \Drupal\webform\Plugin\WebformHandlerInterface::RESULTS_PROCESSED,
 * )
 */
class ZendeskWebformHandler extends WebformHandlerBase
{
    protected ZendeskWrapperInterface $zendesk;

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        $instance = parent::create($container, $configuration, $plugin_id, $plugin_definition);

        $instance->zendesk = $container->get('zendesk.service');

        return $instance;
    }

    public function defaultConfiguration(): array
    {
        return parent::defaultConfiguration() + [
            'name'        => '',
            'email'       => '',
            'message'     => '',
            'subject'     => '',
        ];
    }

    public function getSummary(): array
    {
        $configuration = $this->getConfiguration();
        $settings = $configuration['settings'];

        return [
            '#theme'    => 'webform_handler_zendesk_summary',
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
            $title = (isset($element['#title'])) ? new FormattableMarkup('@title (@key)', ['@title' => $element['#title'], '@key' => $key]) : $key;
            $element_options[$key] = $title;
        }

        $form['zendesk']['config'] = [
            '#type'  => 'details',
            '#title' => $this->t('Zendesk settings'),
            '#open'  => true,
        ];

        $form['zendesk']['config']['name'] = [
            '#type'          => 'select',
            '#title'         => $this->t('Name field'),
            '#options'       => $element_options,
            '#required'      => true,
            '#parents'       => ['settings', 'name'],
            '#default_value' => $this->configuration['name'],
        ];

        $form['zendesk']['config']['email'] = [
            '#type'          => 'select',
            '#title'         => $this->t('Email field'),
            '#options'       => $element_options,
            '#required'      => true,
            '#parents'       => ['settings', 'email'],
            '#default_value' => $this->configuration['email'],
        ];

        $form['zendesk']['config']['message'] = [
            '#type'          => 'select',
            '#title'         => $this->t('Message field'),
            '#options'       => $element_options,
            '#required'      => true,
            '#parents'       => ['settings', 'message'],
            '#default_value' => $this->configuration['message'],
        ];

        $form['zendesk']['config']['subject'] = [
            '#type'          => 'select',
            '#title'         => $this->t('Subject field'),
            '#options'       => $element_options,
            '#required'      => true,
            '#parents'       => ['settings', 'subject'],
            '#default_value' => $this->configuration['subject'],
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

    public function postSave(WebformSubmissionInterface $webform_submission, $update = true): void
    {
        $webform = $webform_submission->getWebform();
        $handler = $webform->getHandler($this->getHandlerId());
        $handler_configuration = $handler->getConfiguration();

        $fieldName = $handler_configuration['settings']['name'] ?? '';
        $fieldEmail = $handler_configuration['settings']['email'] ?? '';
        $fieldMessage = $handler_configuration['settings']['message'] ?? '';
        $fieldSubject = $handler_configuration['settings']['subject'] ?? '';

        $data = $webform_submission->getData();
        $name = $data[$fieldName] ?? '';
        $email = $data[$fieldEmail] ?? '';
        $message = $data[$fieldMessage] ?? '';
        $subject = $data[$fieldSubject] ?? '';

        $contact = new Contact($name, $email, $message, $subject);
        $this->zendesk->create($contact);
    }
}
