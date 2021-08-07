<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/{_locale}/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }
    /**
     * connect to app with github
     * @Route("/connect/github", name="github_connect")
     * @param ClientRegistry $clientRegistry
     * @return RedirectResponse
     */
    public function connect(ClientRegistry $clientRegistry): RedirectResponse
    {

        /**@var GithubClient $client */
        $client = $clientRegistry->getClient('github');
        return $client->redirect(['read:user','user:email']);
    }

    /**
     * connect to app with github
     * @Route("/connect/google", name="google_connect")
     * @param ClientRegistry $clientRegistry
     * @return RedirectResponse
     */
    public function connectGoogle(ClientRegistry $clientRegistry): RedirectResponse
    {

        /**@var GithubClient $client */
        $client = $clientRegistry->getClient('google');
        return $client->redirect();
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
