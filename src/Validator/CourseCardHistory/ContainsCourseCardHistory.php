<?php

namespace App\Validator\CourseCardHistory;


use Symfony\Component\Validator\Constraint;

class ContainsCourseCardHistory extends Constraint
{
    /**
     * @Annotation
     */
    public $message = "Veuillez selectionner une date de validité pour l'ajout d'une nouvelle carte.";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}