<?php

namespace App\Form\Type\Administration;

use App\Validator\DayOff\DayOffType;
use App\Validator\DayOff\DayOffTypeValidator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddDayOffType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateOffBegin', DateTimeType::class, array(
                'invalid_message' => 'Veuillez saisir une date de début de période valide.',
                'label' => 'Date de début d\'indisponibilité',
                'widget' => 'single_text',
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir une date de début de période valide.')),
                    new GreaterThanOrEqual(array(
                        'value' => 'now',
                        'message' => 'Veuillez saisir une date de début de période supérieure à la date du jour.'
                    )),
                    new DateTime(array(
                        'message' => 'Veuillez saisir une date de début de période valide.'
                    ))
                )
            ))
            ->add('dateOffEnd', DateTimeType::class, array(
                'invalid_message' => 'Veuillez saisir une date de fin de période valide.',
                'label' => 'Date de fin d\'indisponibilité',
                'widget' => 'single_text',
                'constraints' => array(
                    new NotBlank(array('message' => 'Veuillez saisir une date de fin de période valide.')),
                    new GreaterThanOrEqual(array(
                        'value' => 'now',
                        'message' => 'Veuillez saisir une date de fin de période supérieure à la date du jour.'
                    )),
                    new DateTime(array(
                        'message' => 'Veuillez saisir une date de fin de période valide.'
                    )),
                    new DayOffType()
                )
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