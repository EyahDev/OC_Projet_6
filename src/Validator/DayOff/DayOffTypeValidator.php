<?php

namespace App\Validator\DayOff;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DayOffTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $dateOffBegin = $this->context->getRoot()->getData()->getDateOffBegin();

        dump($value);
        dump($dateOffBegin);

        if ($value < $dateOffBegin) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}