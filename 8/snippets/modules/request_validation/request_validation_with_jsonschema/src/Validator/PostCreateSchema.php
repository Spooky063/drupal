<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_jsonschema\Validator;

class PostCreateSchema
{
    public function getSchema(): string
    {
        return <<<'JSON'
    {
      "$schema": "https:\\/\\/json-schema.org\\/draft\\/2020-12\\/schema",
      "$id": "https:\\/\\/example.com\\/product.schema.json",
      "title": "Create a Post entity",
      "type": "object",
      "properties": {
        "name": {
          "type": "string",
          "minLength": 5,
          "maxLength": 255,
          "pattern": "^[A-Za-z]{1}[a-z\\s?!]*$"
        },
        "slug": {
          "type": "string",
          "pattern": "^[a-z0-9]+(?:-[a-z0-9]+)*$"
        },
        "content": {
          "type": "string"
        }
      },
      "required": [
        "name",
        "slug",
        "content"
      ],
      "additionalProperties": false
    }
    JSON;
    }
}
