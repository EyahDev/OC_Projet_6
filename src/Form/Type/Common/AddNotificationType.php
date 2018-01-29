<?php

namespace App\Form\Type\Common;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddNotificationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('alertDate', DateType::class, array(
                'label' => 'Date de rappel',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'invalid_message' => 'Veuillez saisir une date de rappel valide.'
            ))
            ->add('alertDescription', TextType::class, array(
                'label' => 'Description du rappel',
                'invalid_message'=> 'Veuillez saisir une description valide',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter le rappel',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
                ));
    }
}