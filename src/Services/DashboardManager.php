<?php

namespace App\Services;


use App\Entity\Horse;
use App\Entity\User;
use App\Form\Type\Administration\AddHorsemanType;
use App\Form\Type\Administration\AddHorseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardManager
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, UserPasswordEncoderInterface $encoder)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
    }

    /* ---------- ADMINISTRATEUR ----------- */

    /**
     * Récupération de tous les utilisateurs avec le role user
     *
     * @return User[]|array
     */
    public function getUsers() {
        return $this->em->getRepository(User::class)->getUsersExceptAdmin();
    }

    /**
     * Récupération de tous les chevaux
     *
     * @return Horse[]|array
     */
    public function getHorses() {
        return $this->em->getRepository(Horse::class)->findAll();
    }

    /**
     * Récupération du formulaire d'ajout d'un cavalier
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getAddHorsemanForm() {
        // Création d'un nouvel utilisateur
        $user = new User();

        // Récupération du formulaire
        return $this->formFactory->create(AddHorsemanType::class ,$user);
    }

    /**
     * Récupération du formulaire d'ajout d'un cheval
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getAddHorseForm() {
        // Création d'un nouveau cheval
        $horse = new Horse();

        // Récupération du formulaire
        return $this->formFactory->create(AddHorseType::class ,$horse);
    }


    public function setNewHorseman(User $data) {
        // Ajout d'un boolean de première connexion
        $data->setFirstConnexion(true);

        // Création et ajout d'un nouveau mot de passe
        $password = $this->encoder->encodePassword($data, $data->getFirstName());
        $data->setPassword($password);

        // Association pour le nom complet
        $data->setCompleteName($data->getFirstName().' '.$data->getLastName());

        // Enregistrement en base de données
        $this->em->persist($data);
        $this->em->flush();
    }

    public function setNewHorse(Horse $data) {
        // Enregistrement en base de données
        $this->em->persist($data);
        $this->em->flush();
    }
}