<?php

namespace App\Controller;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
use App\Services\SecurityManager;
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

        $user = $this->getUser();

        /*--------- ADMINISTRATEUR ----------*/

        if ($this->isGranted('ROLE_ADMIN')) {
            $paginationUsers = $ajaxManager->getPaginatedUsers();
            $paginationHorses = $ajaxManager->getPaginatedHorse();

            $addHorsemanForm = $dashboardManager->getAddHorsemanForm();
            $addHorseForm = $dashboardManager->getAddHorseForm();

            return $this->render('dashboard/admin/dashboard.html.twig', array(
                'user' => $user,
                'paginationUsers' => $paginationUsers,
                'paginationHorses' => $paginationHorses,
                'addHorsemanForm' => $addHorsemanForm->createView(),
                'addHorseForm' => $addHorseForm->createView()
            ));
        }

        /* --------- UTILISATEUR ---------- */
        $paginationCourseCardHistory = $ajaxManager->getPaginatedCourseCardHistory(1, $this->getUser()->getId());

        return $this->render('dashboard/user/dashboard.html.twig', array(
            'user' => $user,
            'paginationCourseCardHistory' => $paginationCourseCardHistory
        ));
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

        // Paginations
        $paginationCourseCardHistory = $ajaxManager->getPaginatedCourseCardHistory(1, $id);
        $paginationsBills = $ajaxManager->getPaginatedBills(1, $id);

        // Formulaire
        $addCourseCard = $dashboardManager->getAddCourseCardForm();
        $updateCourseCardHistory = $dashboardManager->getUpdateCourseCardHistoryForm();

        $addCourseCard->handleRequest($request);
        if ($addCourseCard->isSubmitted() && $addCourseCard->isValid()) {
            $data = $addCourseCard->getData();

            $dashboardManager->setNewCourseCard($user, $data);

            return $this->redirectToRoute('horseman-details', array('id' => $id));
        }
        return $this->render('dashboard/admin/horseman.html.twig', array(
            'user' => $user,
            'paginationCourseCardHistory' => $paginationCourseCardHistory,
            'paginationBills' => $paginationsBills,
            'addCourseCardForm' => $addCourseCard->createView(),
            'updateCourseCardHistory' => $updateCourseCardHistory->createView()
        ));
    }

    /**
     * @Route(path="/dashboard/cours", name="courses")
     */
    public function courses(DashboardManager $dashboardManager) {

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('dashboard/admin/courses.html.twig', array(
                'dayOffForm' => $dashboardManager->getDayOffForm()->createView()
            ));
        }

        return $this->render('dashboard/user/courses.html.twig', array(
            'dayOffForm' => $dashboardManager->getDayOffForm()->createView()
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

        if ($this->isGranted('ROLE_ADMIN')) {
            $contacts = $dashboardManager->getUsefullContacts();
            $ownersPhone = $ajaxManager->getPaginatedOwners();

            $addNewContactForm = $dashboardManager->getNewContactForm();

            return $this->render('dashboard/admin/contacts.html.twig', array(
                'contacts' => $contacts,
                'paginationOwners' => $ownersPhone,
                'addNewContactForm' => $addNewContactForm->createView()
            ));
        }

        $contacts = $dashboardManager->getUsefullContacts();
        $ownersPhone = $ajaxManager->getPaginatedOwners();

        return $this->render('dashboard/user/contacts.html.twig', array(
            'contacts' => $contacts,
            'paginationOwners' => $ownersPhone,
        ));
    }

    /**
     * Page de toutes les factures de l'utilisateurs
     *
     * @param DashboardManager $dashboardManager
     * @param AjaxManager $ajaxManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/dashboard/factures", name="bills")
     */
    public function bills(AjaxManager $ajaxManager) {
        $paginationBills = $ajaxManager->getPaginatedBills(1, $this->getUser()->getId());
        return $this->render('dashboard/user/bills.html.twig', array('paginationBills' => $paginationBills));
    }

    /**
     * Page de mise à jour des coordonnées de l'utilisateur
     *
     * @param DashboardManager $dashboardManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/dashboard/vos-informations", name="user-informations")
     */
    public function userInformations(DashboardManager $dashboardManager) {
        $user = $this->getUser();

        $informationsForm = $dashboardManager->getUserInformationsForm($user);
        return $this->render('common/informations.html.twig', array(
            'informationsForm' => $informationsForm->createView()
        ));
    }

    /**
     * Page de modification de mot de passe de l'utilisateur
     *
     * @param DashboardManager $dashboardManager
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/dashboard/votre-mot-de-passe", name="user-password")
     */
    public function userPassword(SecurityManager $security) {
        $changePasswordForm = $security->getChangePasswordForm();

        return $this->render('common/password.html.twig', array(
            'passwordForm' => $changePasswordForm->createView()
        ));
    }
}