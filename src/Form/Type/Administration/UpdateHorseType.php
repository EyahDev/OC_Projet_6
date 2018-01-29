<?php

namespace App\Form\Type\Administration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class UpdateHorseType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
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
            ->add('submit', SubmitType::class, array(
                'label' => 'Modifier',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            ));
        ;
    }
}