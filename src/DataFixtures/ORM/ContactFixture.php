<?php

namespace App\DataFixtures\ORM;

use App\Entity\Contact;
use App\Entity\ContactType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ContactFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Contacts à ajouter
        $contacts = array(
            array('David Delehelle', '0682058195', 'Maréchal-ferrants'),
            array('Benjamin Texier', '0680426548', 'Maréchal-ferrants'),
            array('Pierre Faivre', '0674333755', 'Maréchal-ferrants'),
            array('Jean Servantie', '0608985143', 'Ostéopathes'),
            array('Frédéric Lavaud', '0607082039', 'Ostéopathes'),
            array('Stéphane Tournier', '0670221940', 'Dentistes équins'),
            array('Pierre Maratier', '0628283412', 'Dentistes équins'),
            array('Clinique De Meyer', '0251305049', 'Vétérinaires'),
            array('Clinique Animéa', '0251305049', 'Vétérinaires')
        );

        // Parcours des types de facture
        foreach ($contacts as $contact) {
            // Création d'un nouveau type
            $newContact = new Contact();

            // Ajout du nom
            $newContact->setName($contact[0]);
            $newContact->setPhone($contact[1]);
            $newContact->setType($this->getReference($contact[2]));

            // Persiste du nouveau type
            $manager->persist($newContact);
        }

        // Enregistrement en base de données de tous les types de factures
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(ContactTypeFixture::class);
    }
}
