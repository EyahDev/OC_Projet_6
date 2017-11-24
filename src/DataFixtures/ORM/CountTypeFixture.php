<?php

namespace App\DataFixtures\ORM;

use App\Entity\CountType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CountTypeFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Types de décomptes
        $types = [
            "Ajout",
            "Retrait"
        ];

        // Parcours des types de décomptes
        foreach ($types as $type) {
            // Création d'un nouveau type
            $countType = new CountType();

            // Ajout du nom
            $countType->setName($type);

            // Persiste du nouveau type
            $manager->persist($countType);
        }

        // Enregistrement en base de données de tous les types de décomptes
        $manager->flush();
    }
}
