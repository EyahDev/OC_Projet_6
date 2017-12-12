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

class AddNewContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nom du contact',
                'invalid_message' => 'Veuillez saisir un nom de contact valide.',
                'constraints' => array(
                    new Length(array('min' => 2, 'minMessage' => 'Le nom du contact doit contenir au minimun {{ limit }} caractères.')),
                    new NotBlank(array('message' => 'Veuillez saisir un nom de contact valide.'))
                )
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Téléphone',
                'invalid_message' => 'Veuilez saisir un numéro de téléphone valide.',
                'constraints' => array(
                    new Type(array('type' => 'numeric', 'message' => 'Le numéro de téléphone ne peut contenir que des chiffres')),
                    new Length(array('max' => 10, 'maxMessage' => 'Le numéro de téléphone doit contenir au maximun {{ limit }} chiffres.')),
                    new NotBlank(array('message' => 'Veuillez saisir numéro de téléphone valide'))
                )
            ))
            ->add('existingType', EntityType::class, array(
                'class' => ContactType::class,
                'query_builder' => function(EntityRepository $em) {
                    return $em->createQueryBuilder('ct')
                        ->orderBy('ct.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Type de contact',
                'placeholder' => 'Selectionnez un type de contact',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un type de contact valide.',
                'required' => false
            ))
            ->add('newType', TextType::class, array(
                'label' => 'Créez un nouveau type de contact',
                'invalid_message' => 'Veuillez saisir un nouveau type de contact valide.',
                'required' => false,
                'constraints' => array(
                    new ContainsContactType(),
                    new Length(array('min' => 2, 'minMessage' => 'Le nouveau type de contact doit contenir au minimun {{ limit }} caractères.')),
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