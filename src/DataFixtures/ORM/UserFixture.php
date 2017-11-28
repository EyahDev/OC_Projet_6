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

        // Création d'un tableau avec tous les utilisateurs
        $users = array(
            array('Séverine', 'Aubry', 'biloute2208@hotmail.com', '682384545'),
            array('Florence', 'Autret', 'florence.autret@hotmail.fr', '626242887'),
            array('Marina', 'Babeau', 'marina1622@hotmail.fr', '612740428'),
            array('Céline', 'Berthe', 'berthe.jeanpierre@wanadoo.fr', '620869648'),
            array('Marie-Cécile', 'Bertrand', 'marie-cecile.bertrand@wanadoo.fr', '637117217'),
            array('Sophia', 'Blithikiotis', 'b.sophia79@gmx.fr', '670305675'),
            array('Véronique', 'Bonin', 'veroniquebonin@neuf.fr', '614147750'),
            array('Lucie', 'Bouletreaux', 'lucie.bouletreaux@gmail.com', '607808652'),
            array('Hélène', 'Brieux', 'pbrieux@wanadoo.fr', '681599985'),
            array('Océane', 'Brisset', 'oceanebrisset17@gmail.com', '669343841'),
            array('Marie-Pierre', 'Cartier', 'mariepierre.cartier@sfr.fr', '770551347'),
            array('Anne-Laure', 'Chabot', 'annelaure.chabot@gmail.com', '644257434'),
            array('Brigitte', 'Claverie', 'bgclaverie@free.fr', '687848920'),
            array('Fabienne', 'Drocourt', 'fabienne.drocourt@laposte.net', '695102143'),
            array('Chantal', 'Dubos', 'duboschantal17@gmail.com', '638021804'),
            array('Camille', 'Dubos', 'camillou1923@gmail.com', '640246131'),
            array('Marie-Paul', 'Durant', 'maduli@hotmail.fr', '679562469'),
            array('Emmanuelle', 'Godeau', 'emma.godeau@gmail.com', '661636019'),
            array('Alexandra', 'Gross', 'algross@free.fr', '648115600'),
            array('Raphaelle', 'Lemoine', 'rap.l@hotmail.fr', '689061547'),
            array('Claude', 'Maye', 'claude.maye@sfr.fr', '671264243'),
            array('Lisa', 'Nottin', 'lisa.nottin@yahoo.fr', '672160546'),
            array('Jocelyne', 'Paillaud', 'jocelyne.paillaud@yahoo.fr', '612497684'),
            array('Amélie', 'Paquereau', 'amelie.paquereau@yahoo.com', '666446142'),
            array('Jean-François', 'Robergeau', 'jf.robergeau@louineau.fr', '672946341'),
            array('Maxence', 'Tisseraud', 'maxence.tiss0@gmail.com', '683802588'),
            array('Léa', 'Troger', 'lea.troger17@gmail.com', '613508257'),
            array('Thomas', 'Veil', 'thomas_c_viel@hotmail.fr', '658080765'),
        );

        // Parcours du tableau
        foreach ($users as $key=>$user) {

            // Création d'un utilisateur ADMIN
            $newUser = new User();

            // Création du mot de passe
            $passwordAdmin = $encoder->encodePassword($newUser, $user[0]);

            // Ecriture des données
            $newUser->setFirstName($user[0]);
            $newUser->setLastName($user[1]);
            $newUser->setUsername($user[2]);
            $newUser->setPassword($passwordAdmin);
            $newUser->setCompleteName($user[0] . ' ' . $user[1]);
            $newUser->setPhone($user[3]);
            $newUser->setRoles(array('ROLE_USER'));
            $newUser->setFirstConnexion(true);


            // Persiste de l'entité
            $manager->persist($newUser);

            $this->addReference($key+1, $newUser);
        }

        // Création d'un utilisateur ADMIN
        $newAdmin = new User();

        // Création du mot de passe
        $passwordAdmin = $encoder->encodePassword($newAdmin, 'admin');

        // Création des informations de l'admin
        $newAdmin->setFirstName('Agnès');
        $newAdmin->setLastName('Y Alcover');
        $newAdmin->setUsername('calcifer.hauru@gmail.com');
        $newAdmin->setPassword($passwordAdmin);
        $newAdmin->setCompleteName('Agnès Y Alcover');
        $newAdmin->setRoles(array('ROLE_ADMIN'));
        $newAdmin->setFirstConnexion(false);

        // Persiste de l'entité
        $manager->persist($newAdmin);

        // Enregistrement en base de données des utilisateurs
        $manager->flush();
    }
}

