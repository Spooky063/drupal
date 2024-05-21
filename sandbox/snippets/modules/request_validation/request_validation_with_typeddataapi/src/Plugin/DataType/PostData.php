<?php

declare(strict_types=1);

namespace Drupal\request_validation_with_typeddataapi\Plugin\DataType;

use Drupal\Core\TypedData\Plugin\DataType\Map;

/**
 * @DataType(
 *    id = "post_response",
 *    label = @Translation("Post response"),
 *    definition_class = "\Drupal\request_validation_with_typeddataapi\TypedData\Definition\PostDefinition"
 * )
 */
class PostData extends Map
{
}
