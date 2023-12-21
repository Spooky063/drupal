<?php

declare(strict_types=1);

namespace Drupal\request_validation_to_object\Dto;

final class PostDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $slug,
        public readonly string $content,
    ) {
    }

    public static function create(array $requestData): self
    {
        return new self(
            name: $requestData['name'],
            slug: $requestData['slug'],
            content: $requestData['content']
        );
    }
}
