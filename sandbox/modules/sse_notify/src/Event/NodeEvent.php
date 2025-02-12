<?php

declare(strict_types=1);

namespace Drupal\sse_notify\Event;

final class NodeEvent
{
    public function __construct(
        private readonly array $data,
    ) {
    }

    public function getName(): string
    {
        return 'node_update';
    }

  /**
   * @return array<string, mixed>
   */
    public function getData(): array
    {
        return $this->data;
    }

    public function jsonSerialize(): string
    {
        return (string) json_encode($this->data);
    }
}
