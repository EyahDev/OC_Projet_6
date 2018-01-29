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
            array('Séverine', 'Aubry', 'biloute2208@hotmail.com', '0682384545'),
            array('Florence', 'Autret', 'florence.autret@hotmail.fr', '0626242887'),
            array('Marina', 'Babeau', 'marina1622@hotmail.fr', '0612740428'),
            array('Céline', 'Berthe', 'berthe.jeanpierre@wanadoo.fr', '0620869648'),
            array('Marie-Cécile', 'Bertrand', 'marie-cecile.bertrand@wanadoo.fr', '0637117217'),
            array('Sophia', 'Blithikiotis', 'b.sophia79@gmx.fr', '0670305675'),
            array('Véronique', 'Bonin', 'veroniquebonin@neuf.fr', '0614147750'),
            array('Lucie', 'Bouletreaux', 'lucie.bouletreaux@gmail.com', '0607808652'),
            array('Hélène', 'Brieux', 'pbrieux@wanadoo.fr', '0681599985'),
            array('Océane', 'Brisset', 'oceanebrisset17@gmail.com', '0669343841'),
            array('Marie-Pierre', 'Cartier', 'mariepierre.cartier@sfr.fr', '0770551347'),
            array('Anne-Laure', 'Chabot', 'annelaure.chabot@gmail.com', '0644257434'),
            array('Brigitte', 'Claverie', 'bgclaverie@free.fr', '0687848920'),
            array('Fabienne', 'Drocourt', 'fabienne.drocourt@laposte.net', '0695102143'),
            array('Chantal', 'Dubos', 'duboschantal17@gmail.com', '0638021804'),
            array('Camille', 'Dubos', 'camillou1923@gmail.com', '0640246131'),
            array('Marie-Paul', 'Durant', 'maduli@hotmail.fr', '0679562469'),
            array('Emmanuelle', 'Godeau', 'emma.godeau@gmail.com', '0661636019'),
            array('Alexandra', 'Gross', 'algross@free.fr', '0648115600'),
            array('Raphaelle', 'Lemoine', 'rap.l@hotmail.fr', '0689061547'),
            array('Claude', 'Maye', 'claude.maye@sfr.fr', '0671264243'),
            array('Lisa', 'Nottin', 'lisa.nottin@yahoo.fr', '0672160546'),
            array('Jocelyne', 'Paillaud', 'jocelyne.paillaud@yahoo.fr', '0612497684'),
            array('Amélie', 'Paquereau', 'amelie.paquereau@yahoo.com', '0666446142'),
            array('Jean-François', 'Robergeau', 'jf.robergeau@louineau.fr', '0672946341'),
            array('Maxence', 'Tisseraud', 'maxence.tiss0@gmail.com', '0683802588'),
            array('Léa', 'Troger', 'lea.troger17@gmail.com', '0613508257'),
            array('Thomas', 'Veil', 'thomas_c_viel@hotmail.fr', '0658080765'),
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

