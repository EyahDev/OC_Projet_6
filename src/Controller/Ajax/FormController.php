<?php

namespace App\Controller\Ajax;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
                $updateContactForm = $updateContactForm->getData();
                $errors = $ajaxManager->validateAjax($updateContactForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $dashboard->updateContact($updateContactForm);
                return new Response('Le contact a été mis à jour.');
            }
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
            $updateCourseCardForm = $dashboard->getUpdateCourseCardHistory();
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
}