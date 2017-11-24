<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/", name="login_page")
     */
    public function login(Request $request, AuthenticationUtils $authUtils) {
        $error = $authUtils->getLastAuthenticationError();

        $lastUserName = $authUtils->getLastUsername();
        return $this->render('login/login.html.twig', array(
            'last_username' => $lastUserName,
            'error' => $error
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/administration", name="admin_page")
     */
    public function administration() {
        return $this->render('login/after.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/mon-compte", name="user_page")
     */
    public function userDashboard() {
        return $this->render('login/after.html.twig');
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
