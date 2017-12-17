<?php

namespace App\Form\Type\Administration;

use App\Entity\CountType;
use App\Validator\CourseCardHistory\ContainsCourseCardHistory;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Type;

class UpdateCourseCardHistoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', TextType::class, array(
                'label' => 'Valeur du décompte',
                'invalid_message' => 'Veuillez saisir une valeur valide.',
                'constraints' => array(
                    new Type(array('type' => 'numeric', 'message' => 'La valeur du décompte ne peut contenir que des chiffres.')),
                    new NotBlank(array('message' => 'Veuillez saisir une valeur de décompte valide.'))
                )
            ))
            ->add('countType', EntityType::class, array(
                'class' => CountType::class,
                'query_builder' => function(EntityRepository $em) {
                    return $em->createQueryBuilder('ct')
                        ->orderBy('ct.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Type de décompte',
                'placeholder' => 'Selectionnez un type de décompte',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un type de décompte valide.',
                'constraints' => array(
                    new NotNull(array('message' => 'Veuillez saisir un type de décompte valide.'))
                )
            ))
            ->add('validityDate', DateTimeType::class,  array(
                'invalid_message' => 'Veuillez saisir une date de validité valide.',
                'label' => 'Date de validité (nouvelle carte)',
                'placeholder' => '01/01/2017',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false,
                'constraints' => array(
                    new ContainsCourseCardHistory(),
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            ));
    }
}