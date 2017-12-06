<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
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
     * Récupération des messages d'erreurs lié à la validation des formulaires
     *
     * @param $form
     * @param null $group
     * @return bool|string
     */
    public function validateAjax($form, $group = null) {
        // Récupération des erreurs liés à la soumission du formulaire
        $errors = $this->validator->validate($form,null, $group);

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
}