<?php

namespace App\Validator\ContactType;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsContactTypeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $existingType = $this->context->getRoot()->getData()['existingType'];

        if (($existingType === null && $value === null) || ($existingType !== null && $value !== null )) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}