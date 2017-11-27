<?php

namespace App\Form\Type\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'invalid_message'=> 'les mots de passe doivent correspondre',
                'first_options' => array('label' => 'Nouveau mot de passe'),
                'second_options' => array('label' => 'Confirmez le mot de passe'),
                'constraints' => array(
                    new NotBlank(array("message" => "Le mot de passe ne peut pas être vide.")),
                    new Length((array(
                        "min" => "6",
                        "minMessage" => "Votre mot de passe doit contenir au moins 6 caractères"))),
                    new Regex(array(
                        "pattern" => "/^(?=.*[a-zA-Z])(?=.*[0-9])/",
                        "match" => "true",
                        "message" => "Votre mot de passe doit contenir au moins une lettre et un chiffre."
                    ))
                )
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Modifier',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
                ));
    }
}