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
     * @Route(path="/dashboard/cavalier/{id}", name="horseman-details")
     */
    public function horsemanDetails(DashboardManager $dashboardManager, Request $request, $id) {
        // Utilisateurs
        $user = $dashboardManager->getUser($id);

        // Formulaires
        $addCourseCard = $dashboardManager->getAddCourseCardForm();

        $addCourseCard->handleRequest($request);
        if ($addCourseCard->isSubmitted() && $addCourseCard->isValid()) {
            $data = $addCourseCard->getData();

            $dashboardManager->setNewCourseCard($user, $data);

            return $this->redirectToRoute('horseman-details', array('id' => $id));
        }


        return $this->render('dashboard/admin/horseman.html.twig', array(
            'user' => $user,
            'addCourseCardForm' => $addCourseCard->createView()
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
//        $updateContactForm = $dashboardManager->getUpdateContactForm($id);

        $addNewContactForm = $dashboardManager->getNewContactForm();

        return $this->render('dashboard/admin/contacts.html.twig', array(
            'contacts' => $contacts,
            'paginationOwners' => $ownersPhone,
            'addNewContactForm' => $addNewContactForm->createView()
        ));
    }

//    public function updateContact(DashboardManager $dashboardManager, $id) {
//        $updateContactForm = $dashboardManager->getUpdateContactForm($id);
//
//        return $this->render('dashboard/admin/contacts.html.twig', array(
//            'updateContactForm' => $updateContactForm->createView()
//        ));
//    }
}