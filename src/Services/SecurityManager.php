<?php

namespace App\Services;

use App\Entity\User;
use App\Form\Type\Security\ResetPasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;

class SecurityManager
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $environment;

    /**
     * @var EncoderFactory
     */
    private $encoder;

    public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $em, \Swift_Mailer $mailer, Environment $environment, UserPasswordEncoderInterface $encoder)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->mailer = $mailer;
        $this->environment = $environment;
        $this->encoder = $encoder;
    }

    /**
     * Récupération de l'utilisateur via son token
     *
     * @param $token
     * @return User|null|object
     */
    public function getUserByToken($token) {
        return $this->em->getRepository(User::class)->findOneBy(array('tokenReset' => $token));
    }

    /**
     * Création d'un token de reset de mot de passe + mail
     *
     * @param $userMail
     * @return bool
     */
    public function lostPassword($userMail) {
        // Récupération des informations de l'utilisateur
        $user = $this->em->getRepository(User::class)->findOneBy(array('username' => $userMail));

        if ($user !== null) {
            // Ajout d'un token pour la reinitialisation du mot de passe
            $user->setTokenReset(bin2hex(random_bytes(strlen($userMail))));

            // Création de la date du jour + 60 minutes
            $date = new \DateTime('now +60 minute');
            $user->setTokenExpirationDate($date);

            // Enregistrement des nouveaux élements en base de données
            $this->em->persist($user);
            $this->em->flush();

            // Récupération du token de reset
            $token = $user->getTokenReset();

            // Création du mail de reset de mot de passe
            $message = (new \Swift_Message('Réinitialisation du mot de passe'))
                ->setFrom(array('noreply@adriendesmet.com' => 'Fief Malzais'))
                ->setTo($userMail)
                ->setBody($this->environment->render('mail/security/reset.html.twig', array('token' => $token)), 'text/html');

            // Envoi du mail
            $this->mailer->send($message);

            // Retourne vrai pour le message de confirmation
            return true;
        } else {
            // Retourne faux pour le message de confirmation
            return false;
        }
    }

    /**
     * Vérification si le token est valide
     *
     * @param $token
     * @return User|bool|null|object
     */
    public function tokenVerification($token) {
        // Récupération de l'utilisateur qui possède le token
        $user = $this->getUserByToken($token);

        // Vérification si l'utilisateur n'est pas null
        if ($user !== null) {
            // Récupèration de la date de validité du token
            $expirationDate = $user->getTokenExpirationDate();

            // Vérification de la date de validité du token
            if ($expirationDate >= new \DateTime()) {
                return $user;
            }
            return false;
        }
        return null;
    }

    /**
     * Récupération du formulaire de reset du mot de passe
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getResetPassordForm() {
        return $this->formFactory->create(ResetPasswordType::class);
    }


    public function resetPassword($password, $token) {
        // Récupération de l'utilisateur
        $user = $this->getUserByToken($token);

        // Création du nouveau mot de passe
        $newPassword = $this->encoder->encodePassword($user, $password);

        // Enregistrement du nouveau mot de passe
        $user->setPassword($newPassword);
        $this->em->persist($user);
        $this->em->flush();
    }
}