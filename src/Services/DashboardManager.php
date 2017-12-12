<?php

namespace App\Services;

use App\Entity\Contact;
use App\Entity\ContactType;
use App\Entity\CountType;
use App\Entity\CourseCard;
use App\Entity\CourseCardHistory;
use App\Entity\Horse;
use App\Entity\User;
use App\Form\Type\Administration\AddCourseCardType;
use App\Form\Type\Administration\AddHorsemanType;
use App\Form\Type\Administration\AddHorseType;
use App\Form\Type\Administration\AddNewContactType;
use App\Form\Type\Administration\UpdateContactType;
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

    /* ---------- Formulaires ----------- */

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
     * Récupération du formulaire de création d'une carte de cours
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getAddCourseCardForm() {
        $newCourseCard = new CourseCard();
        return $this->formFactory->create(AddCourseCardType::class, $newCourseCard);
    }

    /**
     * Récupération du formulaire Ajout d'un contact
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getNewContactForm() {
        return $this->formFactory->create(AddNewContactType::class);
    }

    /**
     * Mise à jour du contact existant
     *
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getUpdateContactForm($id) {
        $existingContact = $this->em->getRepository(ContactType::class)->find($id);
        return $this->formFactory->create(UpdateContactType::class, $existingContact);
    }


    /* ---------- Getters ----------- */

    /**
     * Récupération de tous les utilisateurs avec le role user
     *
     * @return User[]|array
     */
    public function getUsers($firstResult, $perPage) {
        return $this->em->getRepository(User::class)->getUsersExceptAdmin($firstResult, $perPage);
    }

    /**
     * Récupération d'un utilisateur par son id
     *
     * @param $id
     * @return User|null|object
     */
    public function getUser($id) {
        return $this->em->getRepository(User::class)->find($id);
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
     * Récupération de tous les contacts utiles
     *
     * @return ContactType[]|array
     */
    public function getUsefullContacts() {
        return $this->em->getRepository(ContactType::class)->findAll();
    }

    /* ---------- Setters ----------- */

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
     * Ajout d'une carte de cours à un utilisateur
     *
     * @param User $user
     * @param CourseCard $courseCard
     */
    public function setNewCourseCard(User $user, CourseCard $courseCard) {
        $courseCard->setRemainingCourse($courseCard->getBalance());
        $user->setCourseCard($courseCard);

        // Création d'un historique
        $newHistory = new CourseCardHistory();
        $type = $this->em->getRepository(CountType::class)->findOneBy(array('name' => 'Ajout'));


        $newHistory->setCountDate(new \DateTime());
        $newHistory->setValue($courseCard->getBalance());
        $newHistory->setCountType($type);

        $user->addCourseCardHistory($newHistory);
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * Ajout d'un nouveau contact
     *
     * @param $data
     */
    public function setNewContact($data) {
        $newContact = new Contact();

        if ($data['existingType']) {
            $newContact->setName($data['name']);
            $newContact->setPhone($data['phone']);
            $newContact->setType($data['existingType']);

            $this->em->persist($newContact);
            $this->em->flush();
        } else {
            $newContactType = new ContactType();

            $newContact->setName($data['name']);
            $newContact->setPhone($data['phone']);
            $newContactType->setName($data['newType']);
            $newContact->setType($newContactType);

            $this->em->persist($newContactType);
            $this->em->persist($newContact);
            $this->em->flush();
        }
    }


    public function removeCoursesHistory($amount, $user) {

    }

    public function addCoursesHistory($amount, $user) {
    }




}