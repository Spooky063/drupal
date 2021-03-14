<?php

declare(strict_types=1);

namespace Drupal\node_alias\Entity;

use Drupal\Core\Url;

class PathAlias
{
    public Url $source;

    public string $destination = '';

    public function __construct(Url $source, string $destination)
    {
        $this->source = $source;
        $this->destination = $destination;
    }

    public static function create(array $values = []): self
    {
        return new PathAlias($values['source'], $values['destination']);
    }

    public function getSource(): string
    {
        return '/' . $this->source->getInternalPath();
    }

    public function getDestination(): string
    {
        return $this->destination;
    }
}
