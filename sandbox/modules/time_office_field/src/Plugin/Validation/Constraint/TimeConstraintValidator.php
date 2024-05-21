<?php

declare(strict_types=1);

namespace Drupal\time_office_field\Plugin\Validation\Constraint;

use Drupal\time_office_field\Time;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TimeConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        try {
            Time::createFromTimestamp($value);
        } catch (\InvalidArgumentException $e) {
            $this->context->addViolation(TimeConstraint::$message, []);
        }
    }
}
