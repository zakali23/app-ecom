<?php

namespace App\Controller\Pages;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/{_locale}/admin", name="app_admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig');
    }
}
