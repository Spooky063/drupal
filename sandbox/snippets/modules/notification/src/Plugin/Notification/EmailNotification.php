<?php

declare(strict_types=1);

namespace Drupal\notification\Plugin\Notification;

use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Mail\MailManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\notification\Attribute\Notification;
use Drupal\notification\NotificationInterface;
use Drupal\notification\NotificationPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Notification(
    id: "email_notification",
    label: new TranslatableMarkup("Email Notification"),
    description: new TranslatableMarkup("Sending an email."),
)]
final class EmailNotification extends NotificationPluginBase implements NotificationInterface, ContainerFactoryPluginInterface
{
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        protected MailManagerInterface $mail_manager,
        protected LanguageManagerInterface $language_manager,
    ) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
    }

    public static function create(
        ContainerInterface $container,
        array $configuration,
        $plugin_id,
        $plugin_definition
    ): self {
        return new self(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('plugin.manager.mail'),
            $container->get('language_manager'),
        );
    }

    public function sendNotification(array $recipients, string $message): void
    {
        $params = [];
        $params['subject'] = 'Example';
        $params['body'] = $message;
        $to = implode(', ', $recipients);
        $language_id = $this->language_manager->getCurrentLanguage()->getId();

        try {
            $this->mail_manager->mail('notification', 'email_notitication', $to, $language_id, $params);
        } catch (\Exception $exception) {
            dump($exception->getMessage());
        }
    }
}
