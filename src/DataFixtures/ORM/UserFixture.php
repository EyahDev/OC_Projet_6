<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixture extends Fixture
{

    /**
     * Fonction de chargement des fixtures
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Récupération de l'encoder
        $encoder = $this->container->get('security.password_encoder');

        // Création d'un utilisateur ADMIN
        $admin = new User();

        // Création du mot de passe
        $passwordAdmin = $encoder->encodePassword($admin, 'admin');

        // Création des informations de l'admin
        $admin->setFirstName('Agnès')
            ->setLastName('Y Alcover')
            ->setEmail('calcifer.hauru@gmail.com')
            ->setPassword($passwordAdmin)
            ->setRoles(array('ROLE_ADMIN'))
            ->setFirstConnexion(false);

        // Persiste de l'entité
        $manager->persist($admin);

        // Création d'un utilisateur USER
        $user = new User();

        // Création du mot de passe
        $passwordUser = $encoder->encodePassword($user, 'user');

        // Création des informations de l'admin
        $user->setFirstName('Sophia')
            ->setLastName('Blithikiotis')
            ->setEmail('adrien.desmet@hotmail.fr')
            ->setPassword($passwordUser)
            ->setRoles(array('ROLE_USER'))
            ->setFirstConnexion(false);

        // Persiste de l'entité
        $manager->persist($user);

        // Enregistrement en base de données des utilisateurs
        $manager->flush();
    }
}
