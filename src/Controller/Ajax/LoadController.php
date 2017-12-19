<?php

namespace App\Controller\Ajax;

use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LoadController extends Controller
{
    /**
     * Chargement du formulaire de mise à jour du contact
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/update-contact-form/{id}", name="update-contact-form")
     */
    public function loadUpdateContactForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $updateContactForm = $dashboard->getUpdateContactForm($id);
            $contact = $dashboard->getUsefullContact($id);

            return $this->render('dashboard/admin/ajax/modals/editContact.html.twig', array(
                'updateContactForm' => $updateContactForm->createView(),
                'contact' => $contact,
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Chargement du formulaire d'ajout d'une carte de cours
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-course-card-form/{id}", name="add-course-card-form")
     */
    public function loadAddCourseCardForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);

            $addCourseCardForm = $dashboard->getAddCourseCardForm();

            return $this->render('dashboard/admin/ajax/modals/addCourseCard.html.twig', array(
                'addCourseCardForm' => $addCourseCardForm->createView(),
                'user' => $user
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Chargement du formulaire édition d'un cheval
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/update-horse-form/{id}", name="update-horse-form")
     */
    public function loadUpdateHorseForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $updateHorseForm = $dashboard->getUpdateHorseForm($id);
            $horse = $dashboard->getHorse($id);

            return $this->render('dashboard/admin/ajax/modals/editHorse.html.twig', array(
                'updateHorseForm' => $updateHorseForm->createView(),
                'horse' => $horse,
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Chargement du formulaire de mise à jour du type de contact
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/update-contact-type-form/{id}", name="update-contact-type-form")
     */
    public function loadUpdateContactTypeForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $updateContactTypeForm = $dashboard->getUpdateContactTypeForm($id);
            $contactType = $dashboard->getContactType($id);

            return $this->render('dashboard/admin/ajax/modals/editContactType.html.twig', array(
                'updateContactTypeForm' => $updateContactTypeForm->createView(),
                'contactType' => $contactType,
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Chargement du formulaire d'ajout de facture
     *
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-bill-form/{id}", name="add-bill-form")
     */
    public function loadAddBillForm($id ,DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addBillForm = $dashboard->getAddBillForm();
            $user = $dashboard->getUser($id);

            return $this->render('dashboard/admin/ajax/modals/addBill.html.twig', array(
                'addBillForm' => $addBillForm->createView(),
                'user' => $user
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Chargement du mise à jour du formulaire
     *
     * @param $id
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/update-bill-form/{id}", name="update-bill-form")
     */
    public function loadUpdateBillForm($id, DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $updateBillForm = $dashboard->getUpdateBillForm($id);
            $bill = $dashboard->getBill($id);

            return $this->render('dashboard/admin/ajax/modals/updateBill.html.twig', array(
                'updateBillForm' => $updateBillForm->createView(),
                'bill' => $bill
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }
}