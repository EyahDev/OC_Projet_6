<?php

namespace App\Controller\Ajax;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Services\AjaxManager;
use App\Services\DashboardManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PaginationController extends Controller
{
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

    /**
     * Gestion de la pagination de l'historique de la carte de cours
     *
     * @param $id
     * @param AjaxManager $ajaxManager
     * @param $currentPage
     * @param Request $request
     * @return Response
     *
     * @Route(path="dashboard/paginate-course-card-history/{id}/{currentPage}", name="paginate-course-card-history")
     */
    public function paginationCourseCardHistory($id, DashboardManager $dashboard, AjaxManager $ajaxManager, $currentPage, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $user = $dashboard->getUser($id);
            $paginationCourseCardHistory = $ajaxManager->getPaginatedCourseCardHistory($currentPage, $id);

            return $this->render('dashboard/admin/tables/courseCardHistory.html.twig', array(
                'user' => $user,
                'paginationCourseCardHistory' => $paginationCourseCardHistory
            ));
        }
        throw $this->createNotFoundException("Cette page n'existe pas.");
    }
}