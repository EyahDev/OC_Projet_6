<?php

namespace App\Validator\CourseType;


use Symfony\Component\Validator\Constraint;

class ContainsExistingDayOff extends Constraint
{
    /**
     * @var string
     */
    public $message = "Impossible de proposer un cours à cette date, Agnès est absente.";

    /**
     * @return string
     */
    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}