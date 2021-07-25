<?php

namespace App\Controller\Password;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ResetPasswordController extends AbstractController
{
    private SessionInterface $session;
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
    /**
     * reset password
     * @Route("forgot/password/{id}/{token}",name="app_retrieve_credentials",methods={"GET"})
     * @return RedirectResponse
     */
    public function retrieveCredentialson(User $user, string $token)
    {
        $this->session->set('Reset-Password-Token-Url', $token);
        $this->session->set('Reset-Password-Token-Email', $user->getEmail());
        return $this->redirectToRoute('app_reset_password');
    }

    /**
     * @Route("/reset-password",name="app_reset_password",methods={"GET","POST"})
     */
    public function resetPassword()
    {
    }
    private function getCredentialsFromSession(): array
    {
        return [
            'token' => $this->session->get('Reset-Password-Token-Url'),
            'email' => $this->session->get('Reset-Password-Token-Email')
        ];
    }
}
