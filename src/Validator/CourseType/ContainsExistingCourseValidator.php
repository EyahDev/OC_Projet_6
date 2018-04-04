<?php

namespace App\Validator\CourseType;

use App\Entity\Course;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ContainsExistingCourseValidator extends ConstraintValidator
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
     * @param mixed $value
     * @param Constraint $constraint
     * @throws \Exception
     */
    public function validate($value, Constraint $constraint)
    {
        $courseDate = $this->context->getRoot()->getData()['courseDate'] . " " . $value;

        $existingCourse = $this->em->getRepository(Course::class)->getExistingCourse($courseDate);

        if (count($existingCourse) !== 0 ) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}