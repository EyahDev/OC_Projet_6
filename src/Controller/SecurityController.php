<?php

namespace App\Controller;

use App\Services\AjaxManager;
use App\Services\DashboardManager;
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
     * @return Response
     *
     * @Route(path="/", name="login_page")
     */
    public function login(AuthenticationUtils $authUtils) {
        if ($this->getUser()) {
           return $this->redirectToRoute('dashboard');
        }
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
     * @Route(path="/lost_password", name="lost_password")
     */
    public function lostPassword(SecurityManager $security, Request $request) {
        if ($request->isXmlHttpRequest()) {
                $reset = $security->lostPassword($request->get('_email_reset'));
            if ($reset) {
                return new Response('Un email de réinitialisation vient de vous être envoyé.');
            } else {
                return new Response("Ce compte n'existe pas.", 500);
            }
        } else {
            throw $this->createNotFoundException("Cette page n'existe pas.");
        }

    }

    /**
     * @param SecurityManager $security
     * @param $token
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route(path="/reinitialisation/{token}", name="reset_password")
     */
    public function resetPassword(SecurityManager $security, $token, Request $request) {
        // Vérification si le token existe ou est toujours valable
        $tokenVerification = $security->tokenVerification($token);

        if ($tokenVerification) {
            // Récupération du formulaire de reset de mot de passe
            $resetPasswordForm = $security->getResetPassordForm();

            // Hydratation des valeurs du formulaire
            $resetPasswordForm->handleRequest($request);

            // Vérification si le formulaire est soumis
            if ($resetPasswordForm->isSubmitted() && $resetPasswordForm->isValid()) {
                // Récupération des donneés
                $newPassword = $resetPasswordForm->getData()['newPassword'];

                // Création du nouveau mot de passe
                $security->resetPassword($newPassword, $token);

                return $this->redirectToRoute('reset_confirmation');
            }

            return $this->render('/security/reset.html.twig', array(
                'resetPasswordForm' => $resetPasswordForm->createView()
            ));

        } elseif ($tokenVerification === false) {
           throw $this->createNotFoundException("Ce lien n'est plus valable, veuillez refaire une demande réinitialisation de mot de passe.");
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * Modification du mot de passe par l'utilisateur
     *
     * @param Request $request
     * @param DashboardManager $dashboard
     * @param AjaxManager $ajaxManager
     * @return Response
     *
     * @Route(path="dashboard/change-user-password", name="change-user-password")
     */
    public function changeUserPassword(Request $request, SecurityManager $security, AjaxManager $ajaxManager) {
        if ($request->isXmlHttpRequest()) {
            $changePasswordForm = $security->getChangePasswordForm();
            $changePasswordForm->handleRequest($request);

            if ($changePasswordForm->isSubmitted()) {
                $data = $changePasswordForm->getData();
                $errors = $ajaxManager->validateAjaxWithoutEntity($changePasswordForm);

                if ($errors !== true) {
                    return new Response($errors, Response::HTTP_BAD_REQUEST);
                }

                $security->changeUserPassword($this->getUser(), $data);

                return new Response('Votre mot de passe a été mis à jour.');
            }
        }
        throw  $this->createNotFoundException("Cette page n'existe pas.");
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route(path="/confirmation", name="reset_confirmation")
     */
    public function reset_confirmation() {
        return $this->render('security/confirmation.html.twig');
    }
}
