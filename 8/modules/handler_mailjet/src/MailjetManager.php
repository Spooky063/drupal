<?php

declare(strict_types=1);

namespace Drupal\handler_mailjet;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\handler_mailjet\Entity\MailjetData;
use Exception;

class MailjetManager implements MailjetManagerInterface
{
    protected ConfigFactoryInterface $configFactory;

    public function __construct(ConfigFactoryInterface $config_factory)
    {
        $this->configFactory = $config_factory;
    }

    public function getContactList(): array
    {
        $options = [];
        $response = $this->exec(self::MAILJET_ENDPOINT . self::MAILJET_CONTACTLIST);
        if ($response->getCount() > 0) {
            foreach ($response->getData() as $list) {
                $options[$list['ID']] = $list['Name'];
            }
        }

        return $options;
    }

    public function isContactExist(string $email): ?int
    {
        $response = $this->exec(self::MAILJET_ENDPOINT . self::MAILJET_CONTACT . '/' . $email);
        if ($response->getCount() > 0) {
            return (int) $response->getData()[0]['ID'];
        }

        return null;
    }

    public function createContact(string $email): int
    {
        $arguments = [
            'Email' => $email,
        ];
        $response = $this->exec(self::MAILJET_ENDPOINT . self::MAILJET_CONTACT, 'POST', $arguments);
        if ($response->getCount() > 0) {
            return (int) $response->getData()[0]['ID'];
        }
    }

    public function subscribeContact(int $listID, int $contactID): MailjetData
    {
        $arguments = [
            'ContactsLists' => [
                0 => [
                    'ListID' => $listID,
                    'Action' => 'addforce',
                ]
            ]
        ];
        $response = $this->exec(
            self::MAILJET_ENDPOINT . self::MAILJET_CONTACT . '/' . $contactID . '/' . self::MAILJET_MANAGERLIST,
            'POST',
            $arguments
        );

        if (!$response instanceof MailjetData) {
            throw new Exception('Error during subscribe contact');
        }

        return $response;
    }

    private function exec($url, $method = 'GET', $arguments = []): MailjetData
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . '?Limit=0');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_USERPWD, $this->configFactory->get('mailjet.settings')->get('key') . ':' . $this->configFactory->get('mailjet.settings')->get('secret'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($ch, CURLOPT_POST, \count($arguments));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arguments));

        $buffer = curl_exec($ch);

        return new MailjetData($buffer);
    }
}
