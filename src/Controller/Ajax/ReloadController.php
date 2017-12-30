<?php

namespace App\Controller\Ajax;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
use App\Services\SecurityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReloadController extends Controller
{
    /**
     * Rechargement du formulaire d'ajout d'un cavalier
     *
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-horse-form", name="reload-horse-form")
     */
    public function reloadHorseForm(DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addHorseForm = $dashboard->getAddHorseForm();
            return $this->render('dashboard/admin/ajax/forms/addHorse.html.twig', array(
                'addHorseForm' => $addHorseForm->createView()
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement du formulaire d'ajout d'un cavalier
     *
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-horseman-form", name="reload-horseman-form")
     */
    public function reloadHorsemanForm(DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addHorsemanForm = $dashboard->getAddHorsemanForm();
            return $this->render('dashboard/admin/ajax/forms/AddHorseman.html.twig', array(
                'addHorsemanForm' => $addHorsemanForm->createView()
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement du formulaire d'ajout d'un nouveau contact
     *
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-add-contact-form", name="reload-add-contact-form")
     */
    public function reloadNewContactForm(DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addNewContactForm = $dashboard->getNewContactForm();
            return $this->render('dashboard/admin/ajax/forms/addContact.html.twig', array(
                'addNewContactForm' => $addNewContactForm->createView()
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement du formulaire du mise à jour de la carte de cours
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-update-course-card-form/{id}", name="reload-update-course-card-form")
     */
    public function reloadUpdateCourseCardForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);
            $updateCourseCardHistoryForm = $dashboard->getUpdateCourseCardHistoryForm();
            return $this->render('dashboard/admin/ajax/forms/updateCourseCard.html.twig', array(
                'user' => $user,
                'updateCourseCardHistory' => $updateCourseCardHistoryForm->createView()
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-add-bills-form/{id}", name="reload-add-bills-form")
     */
    public function reloadBillsForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);
            return $this->render('dashboard/admin/sections/bills.html.twig', array(
                'user' => $user
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement du formulaire de modification de mot de passe
     *
     * @param SecurityManager $security
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-change-password-form/", name="reload-change-password-form")
     */
    public function reloadChangePasswordForm(SecurityManager $security, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $passwordForm = $security->getChangePasswordForm();
            return $this->render('common/forms/changePassword.html.twig', array(
                'passwordForm' => $passwordForm->createView()
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement des contacts utiles
     *
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-usefull-contacts", name="reload-usefull-contacts")
     */
    public function reloadUseFullContacts(DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $contacts = $dashboard->getUsefullContacts();
            return $this->render('dashboard/admin/tables/usefullContacts.html.twig', array(
                'contacts' => $contacts
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement de la carte de cours de l'utilisateur
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-course-card/{id}", name="reload-course-card")
     */
    public function reloadCourseCard($id, DashboardManager $dashboard, AjaxManager $ajaxManager, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);
            $paginationCourseCardHistory = $ajaxManager->getPaginatedCourseCardHistory(1, $id);
            return $this->render('dashboard/admin/sections/courseCard.html.twig', array(
                'user' => $user,
                'paginationCourseCardHistory' => $paginationCourseCardHistory
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Rechargement des informations du/des chevaux de l'utilisateurs
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-horse-section/{id}", name="reload-horse-section")
     */
    public function reloadHorseSection($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);
            return $this->render('dashboard/admin/sections/horse.html.twig', array(
                'user' => $user
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }
}