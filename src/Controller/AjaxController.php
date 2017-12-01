<?php

namespace App\Controller;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AjaxController extends Controller
{
    /* --------- Pagination ---------- */

    /**
     * Gestion de la pagination des utilisateurs
     *
     * @param DashboardManager $dashboardManager
     * @param $currentPage
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="dashboard/paginate-user/{currentPage}", name="paginate-user")
     */
    public function paginationUsers(AjaxManager $ajaxManager, $currentPage, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $paginationUsers = $ajaxManager->getPaginatedUsers($currentPage);

            return $this->render('dashboard/admin/tables/users.html.twig', array(
                'paginationUsers' => $paginationUsers
            ));
        }

        throw $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Gestion de la pagination des chevaux
     *
     * @param DashboardManager $dashboardManager
     * @param $currentPage
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="dashboard/paginate-horse/{currentPage}", name="paginate-horse")
     */
    public function paginationHorses(AjaxManager $ajaxManager, $currentPage, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $paginationHorses = $ajaxManager->getPaginatedHorse($currentPage);

            return $this->render('dashboard/admin/tables/horses.html.twig', array(
                'paginationHorses' => $paginationHorses
            ));
        }

        throw $this->createNotFoundException("Cette page n'existe pas.");
    }

    /* --------- Formulaire ---------- */

    /**
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-horseman", name="add-horseman")
     */
    public function addHorseman(DashboardManager $dashboard, AjaxManager $ajaxManager, Request $request) {
        if ($request->isXmlHttpRequest()) {

            // Récupération du formulaire d'ajout de cavalier
            $addhorsemanForm = $dashboard->getAddHorsemanForm();

            // Hydratation des valeurs du formulaire
            $addhorsemanForm->handleRequest($request);

            // Vérification si le formulaire est soumis
            if ($addhorsemanForm->isSubmitted()) {
                // Récupération des donneés
                $newHorseman = $addhorsemanForm->getData();

                // Récupération des message d'erreurs
                $errors = $ajaxManager->validateAjax($newHorseman, 'newhorseman');

                if ($errors !== true) {
                    return new Response($errors, 500);
                }

                // Création du nouveau cavalier
                $dashboard->setNewHorseman($newHorseman);

                return new Response('Un nouveau cavalier a été créé.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/add-horse", name="add-horse")
     */
    public function addHorse(DashboardManager $dashboard, AjaxManager $ajaxManager, Request $request) {
        if ($request->isXmlHttpRequest()) {

            // Récupération du formulaire d'ajout de cavalier
            $addhorseForm = $dashboard->getAddHorseForm();

            // Hydratation des valeurs du formulaire
            $addhorseForm->handleRequest($request);

            // Vérification si le formulaire est soumis
            if ($addhorseForm->isSubmitted()) {
                // Récupération des donneés
                $addhorseForm = $addhorseForm->getData();

                // Récupération des message d'erreurs
                $errors = $ajaxManager->validateAjax($addhorseForm, 'newhorse');

                if ($errors !== true) {
                    return new Response($errors, 500);
                }

                // Création du nouveau cavalier
                $dashboard->setNewHorse($addhorseForm);

                return new Response('Un nouveau cheval a été créé.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /* --------- Rechargement ---------- */

    /**
     * @param DashboardManager $dashboard
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/reload-horse-form", name="reload-horse-form")
     */
    public function reloadHorseForm(DashboardManager $dashboard, Request $request) {
        if ($request->isXmlHttpRequest()) {
            // Récupération du formulaire d'ajout de cavalier
            $addHorseForm = $dashboard->getAddHorseForm();

            return $this->render('dashboard/admin/ajax/forms/addHorse.html.twig', array(
                'addHorseForm' => $addHorseForm->createView()
            ));
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }
}