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
        return $this->render('home/index.html.twig');
    }
}
