<?php

namespace App\Form\Type\Administration;

use App\Entity\ContactType;
use App\Validator\ContactType\ContainsContactType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class UpdateContactTypeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom du type de contact',
                'invalid_message' => 'Veuillez saisir un nom de type de contact valide.',
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Modifier',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            ));

    }
}