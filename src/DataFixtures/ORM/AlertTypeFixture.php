<?php

namespace App\DataFixtures\ORM;

use App\Entity\AlertType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AlertTypeFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Types d'alertes à ajouter
        $types = [
            "Cours",
            "Facture",
            "Personnel"
        ];

        // Parcours des types d'alertes
        foreach ($types as $type) {
            // Création d'un nouveau type
            $alertType = new AlertType();

            // Ajout du nom
            $alertType->setName($type);

            // Persiste du nouveau type
            $manager->persist($alertType);
        }

        // Enregistrement en base de données de tout les types de factures
        $manager->flush();
    }
}
