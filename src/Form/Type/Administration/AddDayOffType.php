<?php

namespace App\Form\Type\Administration;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;

class AddDayOffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateBegin', DateType::class, array(
                'invalid_message' => 'Veuillez saisir une date de début de période valide.',
                'label' => 'Date de début d\'indisponibilité',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('timeBegin', TextType::class, array(
                'invalid_message' => 'Veuillez saisir une heure de début de période valide.',
                'label' => 'Heure de début d\'indisponibilité',
            ))
            ->add('dateEnd', DateType::class, array(
                'invalid_message' => 'Veuillez saisir une date de fin de période valide.',
                'label' => 'Date de fin d\'indisponibilité',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))
            ->add('timeEnd', TextType::class, array(
                'invalid_message' => 'Veuillez saisir une heure de début de période valide.',
                'label' => 'Heure de début d\'indisponibilité',
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