<?php

namespace App\Controller;

use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route(path="/dashboard", name="dashboard")
     */
    public function dashboard(DashboardManager $dashboardManager, Request $request) {
        // Récupération des information de l'utilisateur connecté
        $user = $this->getUser();

        /*--------- ADMINISTRATEUR ----------*/

        if ($user->getRoles()[0] === 'ROLE_ADMIN') {
            // Récupération de tous les chevaux existant
            $paginationUsers = $dashboardManager->getPaginatedUsers(1);

            // Récupération de tous les chevaux existant
            $paginationHorses = $dashboardManager->getPaginatedHorse(1);

            // Récupérations des formulaires d'ajout d'un cheval et d'un cavalier
            $addHorsemanForm = $dashboardManager->getAddHorsemanForm();
            $addHorseForm = $dashboardManager->getAddHorseForm();

            // Hydratation des valeurs
            $addHorsemanForm->handleRequest($request);
            $addHorseForm->handleRequest($request);

            // Soumission du formulaire d'un nouvel utilisateur
            if ($addHorsemanForm->isSubmitted() && $addHorsemanForm->isValid()) {
                // Récupération des données
                $data = $addHorsemanForm->getData();

                // Ajout du nouvel utilisateur
                $dashboardManager->setNewHorseman($data);

                // Redirection vers le dashboard
                return $this->redirectToRoute('dashboard');
            }

            // Soumission du formulaire d'un nouveau cheval
            if ($addHorseForm->isSubmitted() && $addHorseForm->isValid()) {
                // Récupération des données
                $data = $addHorseForm->getData();

                // Ajout du nouvel utilisateur
                $dashboardManager->setNewHorse($data);

                // Redirection vers le dashboard
                return $this->redirectToRoute('dashboard');
            }

            return $this->render('dashboard/admin/dashboard.html.twig', array(
                'paginationUsers' => $paginationUsers,
                'paginationHorses' => $paginationHorses,
                'addHorsemanForm' => $addHorsemanForm->createView(),
                'addHorseForm' => $addHorseForm->createView()
            ));
        }

        /*--------- UTILISATEUR ----------*/

        if ($user->getRoles()[0] === 'ROLE_USER') {
            return $this->render('dashboard/user/dashboard.html.twig');
        }
    }

    /**
     * @Route(path="/dashboard/cavalier/{id}", name="horseman-details")
     */
    public function horsemanDetails($id) {
        return $this->render('dashboard/admin/horseman.html.twig');
    }

    /*--------- Pagination ----------*/

    /**
     * @param DashboardManager $dashboardManager
     * @param $currentPage
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="paginate-user/{currentPage}", name="paginate-user")
     */
    public function paginationUsers(DashboardManager $dashboardManager, $currentPage, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $paginationUsers = $dashboardManager->getPaginatedUsers($currentPage);

            return $this->render('dashboard/admin/users.html.twig', array(
                'paginationUsers' => $paginationUsers
            ));
        }

        throw $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * @param DashboardManager $dashboardManager
     * @param $currentPage
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="paginate-horse/{currentPage}", name="paginate-horse")
     */
    public function paginationHorses(DashboardManager $dashboardManager, $currentPage, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $paginationHorses = $dashboardManager->getPaginatedHorse($currentPage);

            return $this->render('dashboard/admin/horses.html.twig', array(
                'paginationHorses' => $paginationHorses
            ));
        }

        throw $this->createNotFoundException("Cette page n'existe pas.");
    }
}