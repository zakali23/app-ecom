<?php

namespace App\Controller\Password;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResetPasswordController extends AbstractController
{
    /**
     * reset password
     * @Route("forgot/password/{id}/{token}",name="app_retrieve_credentials",methods={"GET"})
     * @return RedirectResponse
     */
    public function resetPassword(User $user, string $token)
    {
        dd($user, $token);
    }
}
