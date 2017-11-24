<?php

namespace App\DataFixtures\ORM;

use App\Entity\CourseStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseStatusFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Statuts des cours à ajouter
        $statusName = [
            "En attente de validation",
            "Validé",
        ];

        // Parcours des statuts
        foreach ($statusName as $status) {
            // Création d'un nouveau statut
            $CourseStatus = new CourseStatus();

            // Ajout du nom
            $CourseStatus->setName($status);

            // Persiste du nouveau statut
            $manager->persist($CourseStatus);
        }

        // Enregistrement en base de données de tous les statuts
        $manager->flush();
    }
}
