<?php

namespace App\Controller\Ajax;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\ClickableInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FormController extends Controller
{
    /**
     * Ajout d'un cavalier
     *
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-horseman", name="add-horseman")
     */
    public function addHorseman(DashboardManager $dashboard, AjaxManager $ajaxManager, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addhorsemanForm = $dashboard->getAddHorsemanForm();
            $addhorsemanForm->handleRequest($request);

            if ($addhorsemanForm->isSubmitted()) {
                $newHorseman = $addhorsemanForm->getData();
                $errors = $ajaxManager->validateAjax($newHorseman, 'newhorseman');

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }
                $dashboard->setNewHorseman($newHorseman);
                return new Response('Un nouveau cavalier a été créé.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Ajout d'un cheval
     *
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-horse", name="add-horse")
     */
    public function addHorse(DashboardManager $dashboard, AjaxManager $ajaxManager, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addhorseForm = $dashboard->getAddHorseForm();
            $addhorseForm->handleRequest($request);

            if ($addhorseForm->isSubmitted()) {

                $addhorseForm = $addhorseForm->getData();
                $errors = $ajaxManager->validateAjax($addhorseForm, 'newhorse');

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewHorse($addhorseForm);
                return new Response('Un nouveau cheval a été créé.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Ajout d'un nouveau contact
     *
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-contact", name="add-contact")
     */
    public function addContact(DashboardManager $dashboard, AjaxManager $ajaxManager, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $addContactForm = $dashboard->getNewContactForm();
            $addContactForm->handleRequest($request);

            if ($addContactForm->isSubmitted()) {
                $data = $addContactForm->getData();
                $errors = $ajaxManager->validateAjaxWithoutEntity($addContactForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewContact($data);
                return new Response('Un nouveau contact a été créé.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Mise à jour du contact sélectionnée
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/update-contact/{id}", name="update-contact")
     */
    public function updateContact($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $updateContactForm = $dashboard->getUpdateContactForm($id);
            $updateContactForm->handleRequest($request);

            if ($updateContactForm->isSubmitted()) {

                $data = $updateContactForm->getData();
                $errors = $ajaxManager->validateAjax($data);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->updateContact($data);
                return new Response('Le contact a été mis à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Supression du contact
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @return Response
     *
     * @Route(path="dashboard/delete-contact/{id}", name="delete-contact")
     */
    public function deleteContact($id, Request $request, DashboardManager $dashboard) {
        if ($request->isXmlHttpRequest()) {
            $dashboard->deleteContact($id);
            return new Response('Le contact a été supprimé.');
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Mise à jour du type de contact
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/update-contact-type/{id}", name="update-contact-type")
     */
    public function updateContactType($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $updateContactTypeForm = $dashboard->getUpdateContactTypeForm($id);
            $updateContactTypeForm->handleRequest($request);

            if ($updateContactTypeForm->isSubmitted()) {

                $data = $updateContactTypeForm->getData();
                $errors = $ajaxManager->validateAjax($data);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->updateContactType($data);
                return new Response('Le type de contact a été mis à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Suppression d'un type de contact
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/delete-contact-type/{id}", name="delete-contact-type")
     */
    public function deleteContactType($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $dashboard->deleteContactType($id);
            return new Response('Le Type de contact a été supprimé.');
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }



    /**
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/add-course-card/{id}", name="add-course-card")
     */
    public function addCourseCard($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);

            $addCourseCardForm = $dashboard->getAddCourseCardForm();
            $addCourseCardForm->handleRequest($request);

            if ($addCourseCardForm->isSubmitted()) {
                $addCourseCardForm = $addCourseCardForm->getData();
                $errors = $ajaxManager->validateAjax($addCourseCardForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewCourseCard($user, $addCourseCardForm);
                return new Response('La carte de cours a été ajoutée.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Mise jour de la carte de cours et de son l'historique
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/update-course-card/{id}", name="update-course-card")
     */
    public function updateCourseCard($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            // Récupération de l'utilisateur concerné
            $user = $dashboard->getUser($id);

            // Formulaire
            $updateCourseCardForm = $dashboard->getUpdateCourseCardHistoryForm();
            $updateCourseCardForm->handleRequest($request);

            if ($updateCourseCardForm->isSubmitted()) {
                $data = $updateCourseCardForm->getData();

                $errors = $ajaxManager->validateAjaxWithoutEntity($updateCourseCardForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $update = $dashboard->updateCourseCard($user, $data);

                if (is_string($update)) {
                    return new Response($update, Response::HTTP_BAD_REQUEST);
                }

                return new Response('La carte de cours a été mise à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Mise à jour du cheval concerné
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/update-horse-card/{id}", name="update-horse")
     */
    public function updateHorse($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            // Récupération du cheval concerné
            $horse = $dashboard->getHorse($id);

            // Formulaire
            $updateHorseForm = $dashboard->getUpdateHorseForm($id);
            $updateHorseForm->handleRequest($request);

            if ($updateHorseForm->isSubmitted()) {
                $data = $updateHorseForm->getData();

                $errors = $ajaxManager->validateAjaxWithoutEntity($updateHorseForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->updateHorse($data);

                return new Response('Les informations du cheval ont été mises à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Création d'une nouvelle facture
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     *
     * @Route(path="dashboard/add-bill/{id}", name="add-bill")
     */
    public function addBill($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);

            $addBillForm = $dashboard->getAddBillForm();
            $addBillForm->handleRequest($request);

            if ($addBillForm->isSubmitted()) {
                $data = $addBillForm->getData();
                $errors = $ajaxManager->validateAjax($data);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewBill($user, $data);
                return new Response('La nouvelle facture a été ajoutée.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Mise à jour de la facture existante
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/update-bill/{id}", name="update-bill")
     */
    public function updateBill($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $existingFile = $dashboard->getBill($id)->getPdfPath();
            $updateBillForm = $dashboard->getUpdateBillForm($id);
            $updateBillForm->handleRequest($request);

            if ($updateBillForm->isSubmitted()) {
                $data = $updateBillForm->getData();
                $errors = $ajaxManager->validateAjax($data);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->updateBill($existingFile, $data);
                return new Response('La facture a été mise à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Mise à jour des information de l'utilisateur
     *
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/update-user-informations", name="update-user-informations")
     */
    public function updateUserInformations(Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $userInformationsForm = $dashboard->getUserInformationsForm($this->getUser());
            $userInformationsForm->handleRequest($request);

            if ($userInformationsForm->isSubmitted()) {
                $data = $userInformationsForm->getData();
                $errors = $ajaxManager->validateAjax($data);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->updateUserInformations($data);
                return new Response('Vos informations ont été mises à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Suppression d'une notification par l'utilisateur
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @return Response
     *
     * @Route(path="dashboard/delete-user-notification/{id}", name="delete-user-notification")
     */
    public function deleteNotification($id, Request $request, DashboardManager $dashboard) {
        if ($request->isXmlHttpRequest()) {
            $dashboard->deleteNotification($id);
            return new Response('La notification a été supprimé.');
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Création du rappel personnalisé
     *
     * @param $id
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/add-notification/{id}", name="add-notification")
     */
    public function addNotification($id, Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);

            $notificationForm = $dashboard->getAddNotificationForm();
            $notificationForm->handleRequest($request);

            if ($notificationForm->isSubmitted()) {
                $data = $notificationForm->getData();
                $errors = $ajaxManager->validateAjax($data);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewNotification($user, $data);
                return new Response('Le rappel a été ajouté.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Création de la période d'indisponibilité
     *
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/add-day-off", name="add-day-off")
     */
    public function addDayOff(Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {

            $addDayOffForm = $dashboard->getDayOffForm();
            $addDayOffForm->handleRequest($request);

            if ($addDayOffForm->isSubmitted()) {
                $data = $addDayOffForm->getData();
                $errors = $ajaxManager->validateAjax($addDayOffForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewDayOff($data);
                return new Response('La période d\'indisponibilité a été ajouté.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/add-course", name="add-course")
     */
    public function addCourse(Request $request, DashboardManager $dashboard, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $user = $this->getUser();

            $courseForm = $dashboard->getAddCourseForm();
            $courseForm->handleRequest($request);

            if ($courseForm->isSubmitted()) {
                $data = $courseForm->getData();
                $errors = $ajaxManager->validateAjaxWithoutEntity($courseForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->setNewCourse($user, $data);
                return new Response('La proposition de cours a été créée.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

}