<?php

declare(strict_types=1);

namespace Drupal\handler_mailjet\Entity;

class MailjetData
{
    private int $count;

    private array $data;

    private int $total;

    public function __construct($response)
    {
        $response = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            $this->count = $response['Count'] ?? 0;
            $this->data = $response['Data'] ?? [];
            $this->total = $response['Total'] ?? 0;
        }
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
}
