<?php

namespace App\Controller;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard de l'utilisateur connecté
     *
     * @param DashboardManager $dashboardManager
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/dashboard", name="dashboard")
     */
    public function dashboard(DashboardManager $dashboardManager, AjaxManager $ajaxManager, Request $request) {

        /*--------- ADMINISTRATEUR ----------*/

        if ($this->isGranted('ROLE_ADMIN')) {
            $paginationUsers = $ajaxManager->getPaginatedUsers();
            $paginationHorses = $ajaxManager->getPaginatedHorse();

            $addHorsemanForm = $dashboardManager->getAddHorsemanForm();
            $addHorseForm = $dashboardManager->getAddHorseForm();

            return $this->render('dashboard/admin/dashboard.html.twig', array(
                'paginationUsers' => $paginationUsers,
                'paginationHorses' => $paginationHorses,
                'addHorsemanForm' => $addHorsemanForm->createView(),
                'addHorseForm' => $addHorseForm->createView()
            ));
        }

        /* --------- UTILISATEUR ---------- */

        if ($this->isGranted('ROLE_USER')) {
            return $this->render('dashboard/user/dashboard.html.twig');
        }
    }

    /**
     * Page des détails d'un cavalier
     *
     * @param DashboardManager $dashboardManager
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/dashboard/cavalier/{id}", name="horseman-details")
     */
    public function horsemanDetails(DashboardManager $dashboardManager, AjaxManager $ajaxManager, Request $request, $id) {
        // Utilisateur
        $user = $dashboardManager->getUser($id);

        // Pagination de l'historique de la carte de cours
        $paginationCourseCardHistory = $ajaxManager->getPaginatedCourseCardHistory(1, $id);

        // Formulaire
        $addCourseCard = $dashboardManager->getAddCourseCardForm();
        $updateCourseCardHistory = $dashboardManager->getUpdateCourseCardHistory();

        $addCourseCard->handleRequest($request);
        if ($addCourseCard->isSubmitted() && $addCourseCard->isValid()) {
            $data = $addCourseCard->getData();

            $dashboardManager->setNewCourseCard($user, $data);

            return $this->redirectToRoute('horseman-details', array('id' => $id));
        }
        return $this->render('dashboard/admin/horseman.html.twig', array(
            'user' => $user,
            'paginationCourseCardHistory' => $paginationCourseCardHistory,
            'addCourseCardForm' => $addCourseCard->createView(),
            'updateCourseCardHistory' => $updateCourseCardHistory->createView()
        ));
    }

    /**
     * Page de tous les contacts utiles
     *
     * @param DashboardManager $dashboardManager
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/dashboard/contacts", name="usefull-contacts")
     */
    public function contacts(DashboardManager $dashboardManager, AjaxManager $ajaxManager, Request $request) {
        $contacts = $dashboardManager->getUsefullContacts();
        $ownersPhone = $ajaxManager->getPaginatedOwners();

        $addNewContactForm = $dashboardManager->getNewContactForm();

        return $this->render('dashboard/admin/contacts.html.twig', array(
            'contacts' => $contacts,
            'paginationOwners' => $ownersPhone,
            'addNewContactForm' => $addNewContactForm->createView()
        ));
    }
}