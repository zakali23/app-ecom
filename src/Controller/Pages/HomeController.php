<?php

namespace App\Controller\Pages;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/{_locale}/",requirements={"_locale":"fr|en"}, name="app_home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig');
    }
    /**
     * @Route("/", name="redirection_home")
     */
    public function redi()
    {


        return $this->redirectToRoute('app_home');
    }
}
