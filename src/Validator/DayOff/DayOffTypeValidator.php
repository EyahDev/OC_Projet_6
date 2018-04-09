<?php

namespace App\Validator\DayOff;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DayOffTypeValidator extends ConstraintValidator
{
    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        $dateOffBegin = $this->context->getRoot()->getData()->getDateOffBegin();

        if ($value < $dateOffBegin) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}