<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AjaxManager
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


    private $dashbordManager;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory,
                                UserPasswordEncoderInterface $encoder, ValidatorInterface $validator, DashboardManager $dashboardManager)
    {
        $this->em = $entityManager;
        $this->formFactory = $formFactory;
        $this->encoder = $encoder;
        $this->validator = $validator;
        $this->dashbordManager = $dashboardManager;
    }

    /* ---------- Paginations ----------- */

    /**
     * Gestion de la pagination du tableau des utilisateurs (admin seulement)
     *
     * @param $currentPage
     * @return array
     */
    public function getPaginatedHorse($currentPage = 1) {
        // Définition du nombres d'affichage par page
        $perPage = 10;

        // Calcul du premier résultat à afficher
        $firstResult = ($currentPage-1) * $perPage;

        // Récupération de tous les utilisateurs existant
        $horses = $this->dashbordManager->getHorses($firstResult, $perPage);

        // Calcul du nombre de page neécessaire
        $nbPage = ceil(count($horses) / $perPage);

        return array(
            'horses' => $horses,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage
        );
    }

    /**
     * Gestion de la pagination du tableau des utilisateurs (admin seulement)
     *
     * @param $currentPage
     * @return array
     */
    public function getPaginatedUsers($currentPage = 1) {
        // Définition du nombres d'affichage par page
        $perPage = 10;

        // Calcul du premier résultat à afficher
        $firstResult = ($currentPage-1) * $perPage;

        // Récupération de tous les utilisateurs existant
        $users = $this->dashbordManager->getUsers($firstResult, $perPage);

        // Calcul du nombre de page neécessaire
        $nbPage = ceil(count($users) / $perPage);

        return array(
            'users' => $users,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage
        );
    }

    /**
     * Gestion de la pagination du tableau des Propriétaires (contacts utiles)
     *
     * @param $currentPage
     * @return array
     */
    public function getPaginatedOwners($currentPage = 1) {
        // Définition du nombres d'affichage par page
        $perPage = 10;

        // Calcul du premier résultat à afficher
        $firstResult = ($currentPage-1) * $perPage;

        // Récupération de tous les utilisateurs existant
        $owners = $this->dashbordManager->getUsersPhone($firstResult, $perPage);

        // Calcul du nombre de page neécessaire
        $nbPage = ceil(count($owners) / $perPage);

        return array(
            'owners' => $owners,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage
        );
    }

    /**
     * Gestion de la pagination de l'historique de la carte des cours par utilisateur
     *
     * @param int $currentPage
     * @param $id
     * @return array
     */
    public function getPaginatedCourseCardHistory($currentPage = 1, $id) {
        // Définition du nombres d'affichage par page
        $perPage = 10;

        // Calcul du premier résultat à afficher
        $firstResult = ($currentPage-1) * $perPage;

        // Récupération de tous les utilisateurs existant
        $owners = $this->dashbordManager->getCourseCardHistory($firstResult, $perPage, $id);

        // Calcul du nombre de page neécessaire
        $nbPage = ceil(count($owners) / $perPage);

        return array(
            'history' => $owners,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage
        );
    }

    /**
     * Gestion de laz pagination des factures par utilisateur
     *
     * @param int $currentPage
     * @param $id
     * @return array
     */
    public function getPaginatedBills($currentPage = 1, $id) {
        // Définition du nombres d'affichage par page
        $perPage = 12;

        // Calcul du premier résultat à afficher
        $firstResult = ($currentPage-1) * $perPage;

        // Récupération de tous les utilisateurs existant
        $owners = $this->dashbordManager->getBills($firstResult, $perPage, $id);

        // Calcul du nombre de page neécessaire
        $nbPage = ceil(count($owners) / $perPage);

        return array(
            'bills' => $owners,
            'nbPage' => $nbPage,
            'currentPage' => $currentPage
        );
    }

    /* ---------- Validation forms ----------- */

    /**
     * Récupération des messages d'erreurs lié à la validation des formulaires
     *
     * @param $form
     * @param null $group
     * @return bool|string
     */
    public function validateAjax($form, $constains = null, $group = null) {
        // Récupération des erreurs liés à la soumission du formulaire
        $errors = $this->validator->validate($form, $constains, $group);

        // Vérification du nombre d'erreurs
        if (count($errors) > 0) {
            // Création d'une variable vide
            $errorString = '';

            // Parcours des erreurs
            foreach ($errors as $error) {
                $errorString .=$error->getMessage().'</br>';
            }
            return $errorString;
        }
        return true;
    }

    /**
     * Récupération des erreurs venant d'un formulaire sans entités
     *
     * @param FormInterface $form
     * @return string
     */
    private function getErrorMessages(FormInterface $form) {
        $errors = array();
        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }
        // Récupération des erreurs des formulaires enfant si il y en a
        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }
        $errorsString = implode('<br>',$errors);
        return $errorsString;
    }

    /**
     * Vérification si le formulaire est valide
     *
     * @param FormInterface $form
     * @return bool|string
     */
    public function validateAjaxWithoutEntity(FormInterface $form)
    {
        $errorMessages = $this->getErrorMessages($form);
        if ($errorMessages == '') {
            return true;
        }
        return $errorMessages;
    }
}