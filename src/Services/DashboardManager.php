<?php

namespace App\Services;

use App\Entity\ContactType;
use App\Entity\Horse;
use App\Entity\User;
use App\Form\Type\Administration\AddHorsemanType;
use App\Form\Type\Administration\AddHorseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory, UserPasswordEncoderInterface $encoder, ValidatorInterface $validator)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
        $this->validator = $validator;
    }

    /* ---------- ADMINISTRATEUR ----------- */

    /**
     * Récupération de tous les utilisateurs avec le role user
     *
     * @return User[]|array
     */
    public function getUsers($firstResult, $perPage) {
        return $this->em->getRepository(User::class)->getUsersExceptAdmin($firstResult, $perPage);
    }

    /**
     * Récupération des numéros de téléphones de chaque utilisateurs
     *
     * @return array
     */
    public function getUsersPhone($firstResult, $perPage) {
        return $this->em->getRepository(User::class)->getUsersPhone($firstResult, $perPage);
    }

    /**
     * Récupération de tous les chevaux
     *
     * @return Horse[]|array
     */
    public function getHorses($firstResult, $perPage) {
        return $this->em->getRepository(Horse::class)->getHorses($firstResult, $perPage);
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
        return $this->formFactory->create(AddHorsemanType::class, $user);
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

    /**
     * Création d'un nouvel utilisateur
     *
     * @param User $data
     */
    public function setNewHorseman(User $data) {
        // Ajout d'un boolean de première connexion
        $data->setFirstConnexion(true);

        // Création et ajout d'un nouveau mot de passe
        $password = $this->encoder->encodePassword($data, $data->getFirstName());
        $data->setPassword($password);

        // Association pour le nom complet
        $data->setCompleteName($data->getFirstName().' '.$data->getLastName());

        // Ajout du role
        $data->setRoles(array('ROLE_USER'));

        // Enregistrement en base de données
        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * Création d'un nouveau cheval
     *
     * @param Horse $data
     */
    public function setNewHorse(Horse $data) {
        // Enregistrement en base de données
        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * Récupération de tous les contacts utiles
     *
     * @return ContactType[]|array
     */
    public function getUsefullContacts() {
        return $this->em->getRepository(ContactType::class)->findAll();
    }

    public function getUsefullContactsForm() {

    }
}