<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_typeddataapi\TypedData\Definition;

use Drupal\Core\TypedData\ComplexDataDefinitionBase;
use Drupal\Core\TypedData\DataDefinition;

class PostDefinition extends ComplexDataDefinitionBase
{
    public function getPropertyDefinitions()
    {
        $post = &$this->propertyDefinitions;

        $post['name'] = DataDefinition::create('string')
          ->setLabel('Name')
          ->addConstraint('Length', ['min' => 5])
          ->setRequired(true);

        $post['status'] = DataDefinition::create('boolean')
          ->setLabel('Status')
          ->setRequired(true);

        $post['slug'] = DataDefinition::create('string')
          ->setLabel('Slug')
          ->setRequired(true);

        $post['content'] = DataDefinition::create('string')
          ->setLabel('Content')
          ->setRequired(true);

        return $this->propertyDefinitions;
    }
}
