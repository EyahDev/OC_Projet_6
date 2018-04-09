<?php

namespace App\Form\Type\Users;

use App\Entity\CourseType;
use App\Validator\CourseType\ContainsExistingCourse;
use App\Validator\CourseType\ContainsExistingDayOff;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Time;


class AddCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('courseDate', HiddenType::class)
            ->add('courseHours', TextType::class, array(
                'invalid_message' => 'Veuillez saisir un horaire valide.',
                'label' => 'Horaire du cours',
                'attr' => array('class' => 'timepicker'),
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Veuillez saisir un horaire valide'
                    )),
                    new ContainsExistingCourse(),
                    new ContainsExistingDayOff()

            )))
            ->add('courseType', EntityType::class, array(
                'class' => CourseType::class,
                'choice_label' => 'name',
                'label' => 'Type de cours',
                'placeholder' => 'Selectionnez un type de cours',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un type de cours valide.',
                'constraints' => array(
                    new NotBlank(array(
                        'message' => 'Veuillez saisir un type de cours valide.'
                    )),

            )))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            )
        );
    }
}