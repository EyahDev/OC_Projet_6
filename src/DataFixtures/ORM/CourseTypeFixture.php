<?php

namespace App\DataFixtures\ORM;

use App\Entity\CourseType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CourseTypeFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Types de cours à ajouter
        $types = [
            "Individuel",
            "Duo",
            "Collectif"
        ];

        // Parcours des types de cours
        foreach ($types as $type) {
            // Création d'un nouveau type
            $courseType = new CourseType();

            // Ajout du nom
            $courseType->setName($type);

            // Persiste du nouveau type
            $manager->persist($courseType);
        }

        // Enregistrement en base de données de tout les types de cours
        $manager->flush();
    }
}
