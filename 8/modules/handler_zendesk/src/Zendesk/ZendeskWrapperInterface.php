<?php

declare(strict_types=1);

namespace Drupal\handler_zendesk\Zendesk;

use Drupal\handler_zendesk\Entity\Contact;

interface ZendeskWrapperInterface
{
    public function create(Contact $contact): void;
}
