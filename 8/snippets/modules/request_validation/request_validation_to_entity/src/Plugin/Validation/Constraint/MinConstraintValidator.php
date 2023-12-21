<?php

declare(strict_types=1);

namespace Drupal\request_validation_to_entity\Plugin\Validation\Constraint;

use Exception;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

final class MinConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof MinConstraint) {
            throw new Exception('Error to assign correct constraint object.');
        }

        foreach ($value as $item) {
            if (strlen($item->value) <= $constraint->minValue) {
                $this->context->addViolation(
                    $constraint->minMessage,
                    ['%value' => $item->value, '%min' => $constraint->minValue]
                );
            }
        }
    }
}
