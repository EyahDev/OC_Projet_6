<?php

namespace App\Validator\CourseType;


use Symfony\Component\Validator\Constraint;

class ContainsExistingCourse extends Constraint
{
    /**
     * @Annotation
     */
    public $message = "Un cours existe déjà a cet horaire, veuillez vérifier.";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}