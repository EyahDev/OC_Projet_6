<?php

namespace App\Validator\CourseCardHistory;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsCourseCardHistoryValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        $countType = $this->context->getRoot()->getData()['countType'];

        if ($value === null && $countType->getName() === 'Nouvelle carte') {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}