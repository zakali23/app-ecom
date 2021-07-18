<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_Home")
     */
    public function index()
    {
        return $this->render('user/index.html.twig');
    }
}
