<?php

namespace App\DataFixtures\ORM;

use App\Entity\BillStatus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class BillStatusFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Statuts des factures à ajouter
        $statusName = [
            "En attente de réglement",
            "Réglé",
            "Refusé"
        ];

        // Parcours des statuts
        foreach ($statusName as $status) {
            // Création d'un nouveau statut
            $billStatus = new BillStatus();

            // Ajout du nom
            $billStatus->setName($status);

            // Persiste du nouveau statut
            $manager->persist($billStatus);
        }

        // Enregistrement en base de données de tous les statuts
        $manager->flush();
    }
}
