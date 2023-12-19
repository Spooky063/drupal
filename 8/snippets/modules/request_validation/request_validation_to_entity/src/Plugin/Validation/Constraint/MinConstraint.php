<?php

declare(strict_types=1);

namespace Drupal\request_validation_to_entity\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Constraint(
 *   id = "Min",
 *   label = @Translation("Min", context = "Validation"),
 *   type = "string"
 * )
 */
final class MinConstraint extends Constraint
{
  public int $minValue;

  public string $minMessage = '%value must be greater than %min characters';

  public function getDefaultOption(): ?string
  {
    return 'minValue';
  }

  public function getRequiredOptions(): array
  {
    return ['minValue'];
  }
}
