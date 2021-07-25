<?php

namespace App\Controller\Password;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResetPasswordController extends AbstractController
{
    /**
     * reset password
     * @Route("{_locale/reset/password/{id}/{token}}",name="app_changePassword_credentials")
     * @return void
     */
    public function resetPassword(User $user, string $stoken)
    {
        dd($user, $token);
    }
}
