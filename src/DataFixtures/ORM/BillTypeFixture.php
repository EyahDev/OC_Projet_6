<?php

namespace App\DataFixtures\ORM;

use App\Entity\BillType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BillTypeFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Types de factures à ajouter
        $types = [
            "Facture annuelle",
            "Facture mensuelle",
            "Mensualité",
            "Carte travail du cheval",
            "Un cours (collectif)",
            "Un cours (duo)",
            "Un cours (individuel)",
            "Carte 10 cours (collectif)",
            "Carte 20 cours (collectif)",
            "Carte 30 cours (collectif)",
            "Carte 10 cours (duo)",
            "Carte 20 cours (duo)",
            "Carte 30 cours (duo)",
            "Carte 5 cours (individuel)",
            "Carte 10 cours (individuel)",
        ];

        // Parcours des types de facture
        foreach ($types as $type) {
            // Création d'un nouveau type
            $billType = new BillType();

            // Ajout du nom
            $billType->setName($type);

            // Persiste du nouveau type
            $manager->persist($billType);
        }

        // Enregistrement en base de données de tous les types de factures
        $manager->flush();
    }
}
