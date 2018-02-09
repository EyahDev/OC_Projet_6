<?php

namespace App\Validator\DayOff;


use Symfony\Component\Validator\Constraint;

class DayOffType extends Constraint
{
    /**
     * @Annotation
     */
    public $message = "Veuillez saisir une date supérieur à la date de début de période.";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}