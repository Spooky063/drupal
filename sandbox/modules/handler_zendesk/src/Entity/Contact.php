<?php

declare(strict_types=1);

namespace Drupal\handler_zendesk\Entity;

class Contact
{
    public string $name;

    public string $email;

    public string $message;

    public string $subject;

    public function __construct(string $name, string $email, string $message, string $subject)
    {
        $this->name = $name;
        $this->email = $email;
        $this->message = $message;
        $this->subject = $subject;
    }
}
