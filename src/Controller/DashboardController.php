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
        // Récupération des information de l'utilisateur connecté
        $user = $this->getUser();

        /*--------- ADMINISTRATEUR ----------*/

        if ($this->isGranted('ROLE_ADMIN')) {
            $paginationUsers = $ajaxManager->getPaginatedUsers();
            $paginationHorses = $ajaxManager->getPaginatedHorse();

            $addHorsemanForm = $dashboardManager->getAddHorsemanForm();
            $addHorseForm = $dashboardManager->getAddHorseForm();

            $addHorsemanForm->handleRequest($request);
            $addHorseForm->handleRequest($request);

            if ($addHorsemanForm->isSubmitted() && $addHorsemanForm->isValid()) {
                $data = $addHorsemanForm->getData();

                $dashboardManager->setNewHorseman($data);

                $this->addFlash('confirmation', 'Un nouveau cavalier a été ajouté');

                return $this->redirectToRoute('dashboard');
            }

            if ($addHorseForm->isSubmitted() && $addHorseForm->isValid()) {
                $data = $addHorseForm->getData();

                $dashboardManager->setNewHorse($data);

                $this->addFlash('confirmation', 'Un nouveau cheval a été ajouté');

                return $this->redirectToRoute('dashboard');
            }

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
    public function horsemanDetails($id) {
        return $this->render('dashboard/admin/horseman.html.twig');
    }

    /**
     * @Route(path="/dashboard/contacts", name="usefull-contacts")
     */
    public function contacts(DashboardManager $dashboardManager, AjaxManager $ajaxManager) {
        $contacts = $dashboardManager->getUsefullContacts();
        $ownersPhone = $ajaxManager->getPaginatedOwners();

        return $this->render('dashboard/admin/contacts.html.twig', array(
            'contacts' => $contacts,
            'paginationOwners' => $ownersPhone
        ));
    }
}