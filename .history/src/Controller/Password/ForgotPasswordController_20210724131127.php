<?php

namespace App\Controller\Password;

use Doctrine\ORM\EntityManager;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForgotPasswordType extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SessionInterface $session;
    private UserRepository $user;


    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, UserRepository $user)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->user = $user;
    }

    /**
     * send link with service email for changed password 
     * @Route("/{_locale}/forgot/password", name="app_forgot_password")
     * @param Request $request
     * @return void
     */
    public function sendRecoveryLink(Request $request)
    {

        return $this->render('reset-password/forgotPassword.html.twig');
    }
}
