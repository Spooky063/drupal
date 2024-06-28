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
use Drupal\notification\Plugin\Notification\sms\SmsInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[Notification(
    id: "sms_notification",
    label: new TranslatableMarkup("Sms Notification"),
    description: new TranslatableMarkup("Sending an sms."),
)]
final class SmsNotification extends NotificationPluginBase implements NotificationInterface, ContainerFactoryPluginInterface
{
    /**
     * @param array<mixed, mixed> $configuration
     */
    public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        protected SmsInterface $sms_manager,
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
            $container->get('twilio.service'),
        );
    }

    public function sendNotification(array $recipients, string $message): void
    {
        $this->sms_manager->sendSms($recipients[0], $message);
    }
}
