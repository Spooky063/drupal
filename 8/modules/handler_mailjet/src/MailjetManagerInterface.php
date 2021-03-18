<?php

declare(strict_types=1);

namespace Drupal\handler_mailjet;

use Drupal\handler_mailjet\Entity\MailjetData;

interface MailjetManagerInterface
{
    const MAILJET_ENDPOINT = 'https://api.mailjet.com/v3/REST/';

    const MAILJET_CONTACTLIST = 'contactslist';

    const MAILJET_CONTACT = 'contact';

    const MAILJET_MANAGERLIST = 'managecontactslists';

    public function getContactList(): array;

    public function isContactExist(string $email): ?int;

    public function createContact(string $email): int;

    public function subscribeContact(int $listID, int $contactID): MailjetData;
}
