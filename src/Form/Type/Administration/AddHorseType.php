<?php

namespace App\Form\Type\Administration;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddHorseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user', EntityType::class, array(
                'class' => User::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :roles')
                        ->orderBy('u.lastName', 'ASC')
                        ->setParameter('roles', '%ROLE_USER%');
                },
                'choice_label' => 'completeName',
                'label' => 'Propriétaire',
                'placeholder' => 'Selectionnez un propriétaire',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un propriétaire valide.'
            ))
            ->add('name', TextType::class, array(
                'invalid_message' => 'Veuillez saisir un prénom valide.',
                'label' => 'Nom'
            ))
            ->add('birthDate', BirthdayType::class, array(
                'invalid_message' => 'Veuillez saisir une date de naissance valide.',
                'label' => 'Date de naissance',
                'placeholder' => '01/01/2000',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false
            ))
            ->add('vaccinationDate', DateType::class, array(
                'invalid_message' => 'Veuillez saisir une date de vaccination valide.',
                'label' => 'Dernière vaccination',
                'placeholder' => '01/01/2017',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false
            ))
            ->add('dewormingDate', DateType::class, array(
                'invalid_message' => 'Veuillez saisir une date de vermifugation valide.',
                'label' => 'Dernière vermifugation',
                'placeholder' => '01/01/2017',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'required' => false
            ))
            ->add('blanketsOption', CheckboxType::class, array(
                'invalid_message' => 'Veuillez choisir une gestion couvertures valide.',
                'label' => 'Gestion couvertures',
                'attr' => array('class' => 'filled-in'),
                'required' => false
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            )
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('newhorse'),
        ));
    }
}