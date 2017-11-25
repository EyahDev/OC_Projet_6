<?php

namespace App\Controller;

use App\Services\SecurityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    /**
     * @param AuthenticationUtils $authUtils
     * @param SecurityManager $security
     * @return Response
     *
     * @Route(path="/", name="login_page")
     */
    public function login(AuthenticationUtils $authUtils, SecurityManager $security) {
        //Gestion des erreurs liés à la connexion
        $error = $authUtils->getLastAuthenticationError();

        // Récupération du dernier utilisateur
        $lastUserName = $authUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $lastUserName,
            'error' => $error

        ));
    }

    /**
     * @param SecurityManager $security
     * @param Request $request
     * @return Response
     * @throws \Exception
     *
     * @Route(path="/reset_password", name="reset_password")
     */
    public function resetPassword(SecurityManager $security, Request $request) {
        if ($request->isXmlHttpRequest()) {
            $reset = $security->resetPassword($request->get('_email_reset'));
            if ($reset) {
                return new Response('Un email de réinitialisation vient de vous être envoyé.');
            } else {
                return new Response("Ce compte n'existe pas.", 500);
            }
        } else {
            throw new \Exception("Cette page n'existe pas", 404);
        }

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/administration", name="admin_page")
     */
    public function administration() {
        return $this->render('after.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/mon-compte", name="user_page")
     */
    public function userDashboard() {
        return $this->render('after.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/pagetest", name="test_page")
     */
    public function test() {
        return $this->render('login/aftereee.html.twig');
    }

    /**
     * @throws \Exception
     *
     * @Route(path="/logout", name="logout")
     */
    public function logout() {
        throw new \Exception('This should never be reached!');
    }
}
