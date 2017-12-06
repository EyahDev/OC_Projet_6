<?php

namespace App\DataFixtures\ORM;

use App\Entity\ContactType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ContactTypeFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $contactsType = array(
            'Maréchal-ferrants',
            'Ostéopathes',
            'Dentistes équins',
            'Vétérinaires',
        );

        foreach ($contactsType as $type) {
            $ContactType = new ContactType();
            $ContactType->setName($type);

            $manager->persist($ContactType);

            $this->addReference($type, $ContactType);
        }

        $manager->flush();
    }
}
