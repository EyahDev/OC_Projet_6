<?php
/**
 * Created by PhpStorm.
 * User: Adrien
 * Date: 25/11/2017
 * Time: 18:04
 */

namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;

class SecurityManager
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
    }

    public function resetPassword($userMail) {
        // Récupération des informations de l'utilisateur
        $user = $this->em->getRepository(User::class)->findOneBy(array('username' => $userMail));

        if ($user !== null) {
            // Ajout d'un token pour la reinitialisation du mot de passe
            $user->setTokenReset(md5($userMail));
            // Création de la date du jour + 60 minutes
            $date = new \DateTime('now +60 minute');
            $user->setTokenExpirationDate($date);

            $this->em->persist($user);
            $this->em->flush();

            return true;
        } else {
            return false;
        }
    }
}