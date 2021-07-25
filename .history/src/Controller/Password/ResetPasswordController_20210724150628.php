<?php

namespace App\Controller\Password;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResetPasswordController extends AbstractController
{
    /**
     * reset password
     * @Route("{_locale/reset/password/{id}/{tooken}}",name="app_changePassword_credentials")
     * @return void
     */
    public function resetPassword()
    {
    }
}
