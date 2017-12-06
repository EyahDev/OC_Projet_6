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

    /**
     * Gestion de la pagination des propriétaires
     *
     * @param DashboardManager $dashboardManager
     * @param $currentPage
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="dashboard/paginate-owners/{currentPage}", name="paginate-owners")
     */
    public function paginationOwners(AjaxManager $ajaxManager, $currentPage, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $paginationOwners = $ajaxManager->getPaginatedOwners($currentPage);

            return $this->render('dashboard/admin/tables/owners.html.twig', array(
                'paginationOwners' => $paginationOwners
            ));
        }
        throw $this->createNotFoundException("Cette page n'existe pas.");
    }

    /* --------- Formulaire ---------- */

    /**
     * Ajout d'un cavalier
     *
     * @param DashboardManager $dashboard
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

    /* --------- Rechargement ---------- */

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
}