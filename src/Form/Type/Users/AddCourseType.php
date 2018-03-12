<?php

namespace App\Form\Type\Users;

use App\Entity\CourseType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;


class AddCourseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('courseDate', HiddenType::class)
            ->add('courseHours', TimeType::class, array(
                'invalid_message' => 'Veuillez saisir un horaire valide.',
                'placeholder' => 'Select a value',
                'widget' => 'single_text',
                'attr' => array('class' => 'timepicker')
            ))
            ->add('courseType', EntityType::class, array(
                'class' => CourseType::class,
                'choice_label' => 'name',
                'label' => 'Type de cours',
                'placeholder' => 'Selectionnez un type de cours',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un type de cours valide.'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Valider',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            )
        );
    }
}