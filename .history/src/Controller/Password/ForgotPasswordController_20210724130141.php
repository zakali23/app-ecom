<?php

namespace App\Controller\Password;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForgotPasswordType extends AbstractController
{
    private EntityManagerInterface $entityManager;
}
