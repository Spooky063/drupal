<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Plugin\Validation\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * Checks that the submitted value is a unique integer.
 *
 * @Constraint(
 *   id = "time",
 *   label = @Translation("Time", context = "Validation"),
 *   type = "string"
 * )
 */
class TimeConstraint extends Constraint
{
    public static string $message = 'This value is not a valid time.';
}
