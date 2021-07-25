<?php

namespace App\Controller\Password;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ForgotPasswordType extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SessionInterface $session;
    private UserRepository $user;

    public function __construct(EntityManagerInterface $entityManager,SessionInterface $session,UserRepository $user)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->user = $user;
    }

    public function send
}
