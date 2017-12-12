<?php

namespace App\Form\Type\Administration;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCourseCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('validityDate', DateType::class, array(
                'invalid_message' => 'Veuillez saisir une date de validité valide.',
                'label' => 'Date de validité de la carte',
                'placeholder' => '01/01/2017',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('balance', IntegerType::class, array(
                'invalid_message' => 'Veuillez saisir un nombre de cours valide.',
                'label' => 'Nombre de cours de la carte',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            )
        );
    }

//    public function configureOptions(OptionsResolver $resolver)
//    {
//        $resolver->setDefaults(array(
//            'validation_groups' => array('newhorse'),
//        ));
//    }
}