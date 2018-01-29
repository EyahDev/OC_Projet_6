<?php

namespace App\DataFixtures\ORM;

use App\Entity\Horse;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class HorseFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Création d'un tableau avec tous les chevaux
        $horses = array(
            array("Helle d'ancoeur", new \DateTime('2017-11-23'), '1'),
            array("Jeepers", new \DateTime('2017-11-23'), '2'),
            array("Radia", new \DateTime('2017-11-23'), '3'),
            array("Nocturna de Beauvoir", new \DateTime('2017-11-23'), '4'),
            array("Sherpa", null, 5),
            array("Orée de la Moisonnais", new \DateTime('2017-11-23'), '6'),
            array("Javelle de la prée", new \DateTime('2017-11-23'), '7'),
            array("Owen", new \DateTime('2017-11-23'), '9'),
            array("Batifolia", new \DateTime('2017-11-23'), '10'),
            array("Black", new \DateTime('2017-11-23'), '11'),
            array("Paséo", new \DateTime('2017-11-23'), '14'),
            array("Ongie", new \DateTime('2017-11-23'), '15'),
            array("Polco", new \DateTime('2017-11-23'), '17'),
            array("Kellesouf", new \DateTime('2017-11-23'), '18'),
            array("Canelle", null, '20'),
            array("Casimodo", new \DateTime('2017-11-23'), '21'),
            array("Chequita", null, '22'),
            array("Obscure", new \DateTime('2017-11-23'), '23'),
            array("Vogue", new \DateTime('2017-10-02'), '24'),
            array("Uruguay de soulac", new \DateTime('2017-11-23'), '25'),
            array("Thavane d'éol", new \DateTime('2017-11-23'), '25'),
            array("Usam", new \DateTime('2017-11-23'), '26'),
            array("Tunis", new \DateTime('2017-11-23'), '28'),
        );

        // Parcours du tableau
        foreach ($horses as $horse) {
            // Création d'un cheval
            $newHorse = new Horse();

            // Ecriture des données
            $newHorse->setName($horse[0]);
            $newHorse->setDewormingDate($horse[1]);
            $newHorse->setBlanketsOption(false);
            $newHorse->setUser($this->getReference($horse[2]));

            // Persiste de l'entité
            $manager->persist($newHorse);
        }

        // Enregistrement en base de données des chevaux
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(UserFixture::class);
    }
}
