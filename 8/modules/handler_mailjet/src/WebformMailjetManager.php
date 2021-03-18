<?php

declare(strict_types=1);

namespace Drupal\handler_mailjet;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\webform\WebformInterface;
use Drupal\webform\WebformSubmissionInterface;

class WebformMailjetManager
{
    protected LoggerChannelInterface $logger;

    protected MailjetManagerInterface $mailjet;

    public function __construct(LoggerChannelInterface $logger, MailjetManagerInterface $mailjet)
    {
        $this->logger = $logger;
        $this->mailjet = $mailjet;
    }

    /**
     * @throws \Exception
     */
    public function subscribe(EntityInterface $entity, $handler_id = null): void
    {
        if ($entity instanceof WebformSubmissionInterface) {
            // Entity
            $webform_submission = $entity;
            $webform = $webform_submission->getWebform();

            // Handler
            $handler = $webform->getHandler($handler_id);
            $handler_configuration = $handler->getConfiguration();

            $listID = $handler_configuration['settings']['mailjet_contact_list_id'];

            $email_field = $handler_configuration['settings']['mailjet_email_field'];
            /** @var string $email */
            $email = $webform_submission->getElementData($email_field);

            if ($email !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $contactID = $this->mailjet->isContactExist($email);
                if (null === $contactID) {
                    $contactID = $this->mailjet->createContact($email);
                }

                $subscribe = $this->mailjet->subscribeContact((int) $listID, (int) $contactID);
                if (1 === $subscribe->getCount()) {
                    $view = (new TranslatableMarkup('View'))->__toString();
                    $context = [
                        '%submission' => $webform_submission->label(),
                        '%email'      => $email,
                        '%handler'    => $handler->label(),
                        '%mailjet'    => $listID,
                        'link'        => $webform_submission->toLink($view)->toString(),
                    ];
                    $this->logger->notice(
                        '%submission: Email %email by %handler handler was sent on contact %mailjet.',
                        $context
                    );
                } else {
                    throw new \Exception('error');
                }
            } else {
                throw new \Exception('error email format');
            }
        } elseif ($entity instanceof WebformInterface) {
        } else {
            throw new \Exception('Error');
        }
    }
}
