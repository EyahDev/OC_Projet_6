<?php

namespace App\Form\Type\Administration;

use App\Entity\Horse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddHorsemanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'invalid_message' => 'Veuillez saisir un prénom valide.',
                'label' => 'Prénom'
            ))
            ->add('lastName', TextType::class, array(
                'invalid_message' => 'Veuillez saisir un nom valide.',
                'label' => 'Nom'
            ))
            ->add('address', TextType::class, array(
                'invalid_message' => 'Veuillez saisir une adresse valide.',
                'label' => 'Adresse',
                'required' => false
            ))
            ->add('zip_code', TextType::class, array(
                'invalid_message' => 'Veuillez saisir un code postal valide.',
                'label' => 'Code postal',
                'required' => false
            ))
            ->add('country', TextType::class, array(
                'invalid_message' => 'Veuillez saisir une ville valide.',
                'label' => 'Ville',
                'required' => false
            ))
            ->add('username', EmailType::class, array(
                'invalid_message' => 'Veuillez saisir un prénom valide.',
                'label' => 'Email'
            ))
            ->add('phone', NumberType::class, array(
                'invalid_message' => 'Veuillez saisir un prénom valide.',
                'label' => 'Téléphone',
                'required' => false
            ))
            ->add('horse', EntityType::class, array(
                'class' => Horse::class,
                'choice_label' => 'name',
                'label' => 'Cheval',
                'placeholder' => 'Selectionnez un cheval',
                'required' => false,
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un cheval valide.'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            )
        );
    }
}