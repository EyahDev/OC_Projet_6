<?php

namespace App\Validator\CourseType;

use App\Entity\Course;
use App\Entity\DayOff;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsExistingDayOffValidator extends ConstraintValidator
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * ContainsExistingCourseValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Vérification d'une période d'absence
     *
     * @param mixed $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        $courseDate = $this->context->getRoot()->getData()['courseDate'] . " " . $value;

        $existingDayOff = $this->em->getRepository(DayOff::class)->getExistingDayOff($courseDate);

        if (count($existingDayOff) !== 0 ) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}