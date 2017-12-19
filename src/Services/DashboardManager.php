<?php

namespace App\Services;

use App\Entity\Alert;
use App\Entity\AlertType;
use App\Entity\Bill;
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
use App\Form\Type\Administration\AddNewBillType;
use App\Form\Type\Administration\AddNewContactType;
use App\Form\Type\Administration\UpdateBillType;
use App\Form\Type\Administration\UpdateContactType;
use App\Form\Type\Administration\UpdateContactTypeType;
use App\Form\Type\Administration\UpdateCourseCardHistoryType;
use App\Form\Type\Administration\UpdateHorseType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

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

    /**
     * @var
     */
    private $billsDirectory;

    /**
     * @var Filesystem
     */
    private $fileSystem;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $environment;

    public function __construct($billsDirectory, EntityManagerInterface $entityManager,
                                FormFactoryInterface $formFactory, UserPasswordEncoderInterface $encoder,
                                ValidatorInterface $validator, Filesystem $filesystem, \Swift_Mailer $mailer,
                                Environment $environment)
    {
        $this->billsDirectory = $billsDirectory;
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
        $this->validator = $validator;
        $this->fileSystem = $filesystem;
        $this->mailer = $mailer;
        $this->environment = $environment;
    }

    /* ---------- ADMINISTRATEUR ----------- */

    /* ---------- Formulaires ----------- */

    /**
     * Récupération du formulaire d'ajout d'un cavalier
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getAddHorsemanForm()
    {
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
    public function getAddHorseForm()
    {
        // Création d'un nouveau cheval
        $horse = new Horse();

        // Récupération du formulaire
        return $this->formFactory->create(AddHorseType::class, $horse);
    }

    /**
     * Récupération du formulaire de création d'une carte de cours
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getAddCourseCardForm()
    {
        $newCourseCard = new CourseCard();
        return $this->formFactory->create(AddCourseCardType::class, $newCourseCard);
    }

    /**
     * Récupération du formulaire Ajout d'un contact
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getNewContactForm()
    {
        return $this->formFactory->create(AddNewContactType::class);
    }

    /**
     * Mise à jour du contact existant
     *
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getUpdateContactForm($id)
    {
        $existingContact = $this->em->getRepository(Contact::class)->find($id);
        return $this->formFactory->create(UpdateContactType::class, $existingContact);
    }

    /**
     *  Mise à jour de l'historique de la carte de cours
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getUpdateCourseCardHistoryForm()
    {
        return $this->formFactory->create(UpdateCourseCardHistoryType::class);
    }

    /**
     * Récupération du formulaire d'édition d'un cheval
     *
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getUpdateHorseForm($id)
    {
        $existingHorse = $this->em->getRepository(Horse::class)->find($id);
        return $this->formFactory->create(UpdateHorseType::class, $existingHorse);
    }

    /**
     * Récupération du formulaire d'édition du type de contact
     *
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getUpdateContactTypeForm($id) {
        $existingContactType = $this->em->getRepository(ContactType::class)->find($id);
        return $this->formFactory->create(UpdateContactTypeType::class, $existingContactType);
    }

    public function getAddBillForm() {
        $newBill = new Bill();
        return $this->formFactory->create(AddNewBillType::class, $newBill);
    }

    /**
     * Récupération du formulaire de mise à jour de la facture
     *
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getUpdateBillForm($id) {
        $existingBill = $this->getBill($id);
        return $this->formFactory->create(UpdateBillType::class, $existingBill);
    }

    /* ---------- Getters ----------- */

    /**
     * Récupération de tous les utilisateurs avec le role user avec pagination
     *
     * @param $firstResult
     * @param $perPage
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getUsers($firstResult, $perPage)
    {
        return $this->em->getRepository(User::class)->getUsersExceptAdmin($firstResult, $perPage);
    }

    /**
     * Récupération d'un utilisateur par son id
     *
     * @param $id
     * @return User|null|object
     */
    public function getUser($id)
    {
        return $this->em->getRepository(User::class)->find($id);
    }

    /**
     * Récupération des numéros de téléphones de chaque utilisateurs avec pagination
     *
     * @param $firstResult
     * @param $perPage
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getUsersPhone($firstResult, $perPage)
    {
        return $this->em->getRepository(User::class)->getUsersPhone($firstResult, $perPage);
    }

    /**
     * Récupération de tous les chevaux avec pagination
     *
     * @param $firstResult
     * @param $perPage
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getHorses($firstResult, $perPage)
    {
        return $this->em->getRepository(Horse::class)->getHorses($firstResult, $perPage);
    }

    /**
     * Récupération d'un cheval spécifique par son id
     *
     * @param $id
     * @return Horse|null|object
     */
    public function getHorse($id)
    {
        return $this->em->getRepository(Horse::class)->find($id);
    }

    /**
     * Récupération de tous les contacts utiles
     *
     * @return ContactType[]|array
     */
    public function getUsefullContacts()
    {
        return $this->em->getRepository(ContactType::class)->findAll();
    }

    /**
     * Récupération des informations d'un contact spécifique
     *
     * @param $id
     * @return Contact|null|object
     */
    public function getUsefullContact($id)
    {
        return $this->em->getRepository(Contact::class)->find($id);
    }

    /**
     * Récupération d'une type de contact spécifique
     *
     * @param $id
     * @return ContactType|null|object
     */
    public function getContactType($id)
    {
        return $this->em->getRepository(ContactType::class)->find($id);
    }

    /**
     * Récupération de l'historique de la carte de cours de son utilisateur avec pagination
     *
     * @param $firstResult
     * @param $perPage
     * @param $id
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getCourseCardHistory($firstResult, $perPage, $id)
    {
        return $this->em->getRepository(CourseCardHistory::class)->getHistoryByUser($firstResult, $perPage, $id);
    }

    /**
     * @param $firstResult
     * @param $perPage
     * @param $id
     * @return \Doctrine\ORM\Tools\Pagination\Paginator
     */
    public function getBills($firstResult, $perPage, $id)
    {
        return $this->em->getRepository(Bill::class)->getBillsByUser($firstResult, $perPage, $id);
    }

    /**
     * Récupération de la facture sélectionnée
     *
     * @param $id
     * @return Bill|null|object
     */
    public function getBill($id) {
        return $this->em->getRepository(Bill::class)->find($id);
    }

    /* ---------- Setters ----------- */

    /**
     * Création d'un nouvel utilisateur
     *
     * @param User $data
     */
    public function setNewHorseman(User $data)
    {
        // Ajout d'un boolean de première connexion
        $data->setFirstConnexion(true);

        // Création et ajout d'un nouveau mot de passe
        $password = $this->encoder->encodePassword($data, $data->getFirstName());
        $data->setPassword($password);

        // Association pour le nom complet
        $data->setCompleteName($data->getFirstName() . ' ' . $data->getLastName());

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
    public function setNewHorse(Horse $data)
    {
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
    public function setNewCourseCard(User $user, CourseCard $courseCard)
    {
        $courseCard->setRemainingCourse($courseCard->getBalance());
        $user->setCourseCard($courseCard);

        // Création d'un historique
        $newHistory = new CourseCardHistory();
        $type = $this->em->getRepository(CountType::class)->findOneBy(array('name' => 'Nouvelle carte'));


        $newHistory->setCountDate(new \DateTime());
        $newHistory->setValue($courseCard->getBalance());
        $newHistory->setRemainingCourse($courseCard->getBalance());
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
    public function setNewContact($data)
    {
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

    /**
     * Création de la nouvelle facture
     *
     * @param User $user
     * @param Bill $data
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function setNewBill(User $user, Bill $data)
    {
        $data->setBillDate(new \DateTime());

        $path = $this->billsDirectory;
        $newFile = $data->getPdfPath();
        $fileName = md5(uniqid()).'.'.$newFile->guessExtension();
        $newFile->move($path, $fileName);
        $filePath = "uploads/bills/".$fileName;

        $data->setPdfPath($filePath);
        $user->addBill($data);

        // Création d'une alerte
        $alert = new Alert();
        $alert->setAlertDate(new \DateTime());
        $alert->setType($this->em->getRepository(AlertType::class)->findOneBy(array('name' => 'Facture')));
        $alert->setAlertDescription('Une nouvelle facture est disponible !');

        $user->addAlert($alert);

        $this->em->persist($user);
        $this->em->flush();

        // Envoi d'un email
        $message = (new \Swift_Message('Une nouvelle facture est disponible'))
            ->setFrom(array('noreply@adriendesmet.com' => 'Fief Malzais'))
            ->setTo($user->getUsername())
            ->setBody($this->environment->render('mail/bills/bill.html.twig', array('bill' => $data)), 'text/html')
            ->attach(\Swift_Attachment::fromPath($filePath));
        $this->mailer->send($message);

    }

    /**
     * Mise à jour de la facture existante
     *
     * @param $existingFile
     * @param Bill $data
     */
    public function updateBill($existingFile, Bill $data)
    {
        $path = $this->billsDirectory;

        $newFile = $data->getPdfPath();

        if ($newFile === null) {
            $data->setPdfPath($existingFile);
        } else {
            $this->fileSystem->remove($existingFile);
            $fileName = md5(uniqid()).'.'.$newFile->guessExtension();
            $newFile->move($path, $fileName);
            $filePath = "uploads/bills/".$fileName;
            $data->setPdfPath($filePath);
        }

        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * Mise à jour du contact
     *
     * @param Contact $data
     */
    public function updateContact(Contact $data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * Suppression du contact
     *
     * @param $id
     */
    public function deleteContact($id)
    {
        $this->em->remove($this->getUsefullContact($id));
        $this->em->flush();
    }

    /**
     * Mise à jour du type de contact
     *
     * @param ContactType $data
     */
    public function updateContactType(ContactType $data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }

    /**
     * Suppression du type de contact
     *
     * @param $id
     */
    public function deleteContactType($id)
    {
        $this->em->remove($this->getContactType($id));
        $this->em->flush();
    }

    /**
     * Mise à jour de la carte de cours et ajout dans l'historique
     *
     * @param User $user
     * @param $data
     * @return bool
     */
    public function updateCourseCard(User $user, $data)
    {
        if ($data['countType']->getName() == 'Nouvelle carte') {
            // Ajout de l'historique
            $history = new CourseCardHistory();
            $history->setUser($user);
            $history->setCountType($data['countType']);
            $history->setValue($data['value']);
            $history->setCountDate(new \DateTime());

            $user->getCourseCard()->setBalance($data['value']);

            if ($user->getCourseCard()->getValidityDate() < new \DateTime()) {
                $history->setRemainingCourse($data['value']);
                $user->getCourseCard()->setRemainingCourse($data['value']);
            } else {
                $history->setRemainingCourse($data['value'] + $user->getCourseCard()->getRemainingCourse());
                $user->getCourseCard()->setRemainingCourse($user->getCourseCard()->getRemainingCourse() + $data['value']);
            }

            $user->getCourseCard()->setValidityDate($data['validityDate']);
            $user->addCourseCardHistory($history);

        } else {
            $history = new CourseCardHistory();

            if ($data['countType']->getName() == 'Correction : retrait' || $data['countType']->getName() == 'Retrait') {
                if ($data['value'] > $user->getCourseCard()->getRemainingCourse()) {
                    return 'Il ne reste pas suffisamment de cours sur la carte.';
                } elseif ($user->getCourseCard()->getValidityDate() < new \DateTime()) {
                    return 'La carte n\'est plus valable.';
                }

                $history->setRemainingCourse($user->getCourseCard()->getRemainingCourse() - $data['value']);
                $user->getCourseCard()->setRemainingCourse($user->getCourseCard()->getRemainingCourse() - $data['value']);
            } else {
                $history->setRemainingCourse($user->getCourseCard()->getRemainingCourse() + $data['value']);
                $user->getCourseCard()->setRemainingCourse($user->getCourseCard()->getRemainingCourse() + $data['value']);
            }

            //Ajout de l'historique
            $history->setUser($user);
            $history->setCountType($data['countType']);
            $history->setValue($data['value']);
            $history->setCountDate(new \DateTime());

            $user->addCourseCardHistory($history);
        }
        $this->em->persist($user);
        $this->em->flush();

        return true;
    }

    /**
     * Mise à jour des informations du cheval
     *
     * @param Horse $data
     */
    public function updateHorse(Horse $data)
    {
        $this->em->persist($data);
        $this->em->flush();
    }
}