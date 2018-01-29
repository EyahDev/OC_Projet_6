<?php

namespace App\Validator\ContactType;


use Symfony\Component\Validator\Constraint;

class ContainsContactType extends Constraint
{
    /**
     * @Annotation
     */
    public $message = "Vous devez selectionnez soit un type de contact existant soit en créer un nouveau.";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}