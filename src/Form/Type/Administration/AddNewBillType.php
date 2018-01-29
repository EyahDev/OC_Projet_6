<?php

namespace App\Form\Type\Administration;

use App\Entity\BillStatus;
use App\Entity\BillType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class AddNewBillType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', EntityType::class, array(
                'class' => BillType::class,
                'query_builder' => function(EntityRepository $em) {
                    return $em->createQueryBuilder('bt')
                        ->orderBy('bt.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Type de facture',
                'placeholder' => 'Selectionnez un type de facture',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un type de facture valide.',
            ))
            ->add('amount', TextType::class, array(
                'label' => 'Montant de la facture',
                'invalid_message' => 'Veuillez saisir un montant de facture valide.'
            ))
            ->add('status', EntityType::class, array(
                'class' => BillStatus::class,
                'query_builder' => function(EntityRepository $em) {
                    return $em->createQueryBuilder('bs')
                        ->orderBy('bs.name', 'ASC');
                },
                'choice_label' => 'name',
                'label' => 'Statut de la facture',
                'placeholder' => 'Selectionnez un statut de facture',
                'expanded' => false,
                'multiple' => false,
                'invalid_message' => 'Veuillez saisir un statut de facture valide.',
            ))
            ->add('pdfPath', FileType::class, array(
                'label' => 'Facture',
                'invalid_message' => 'Veuillez saisir un facture valide.'
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Ajouter',
                'attr' => array(
                    'class' => 'btn waves-effect waves-light'
                )
            ));
    }
}