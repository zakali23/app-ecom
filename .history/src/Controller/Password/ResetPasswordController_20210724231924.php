<?php

namespace App\Controller\Password;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ResetPasswordController extends AbstractController
{
    private SessionInterface $session;
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(SessionInterface $session, EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->session = $session;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
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
     * @Route("{_locale}/reset-password",name="app_reset_password",methods={"GET","POST"})
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $credentials = $this->getCredentialsFromSession();
        $user = $this->userRepository->findOneBy([
            'email' => $credentials['email']
        ]);
        if (!$user) {
            return $this->redirectToRoute('app_forgot_password');
        }
        /** @var \DateTimeImmutable $dateLimited*/
        $dateLimited = $user->getForgotPasswordTokenMustBeVerifiedBefore();

        if (($user->getForgotPasswordToken() === null) || ($user->getForgotPasswordToken() !== $credentials['token']) || ($this->isStillValid($user->getForgotPasswordTokenMustBeVerifiedBefore()))) {
            return $this->redirectToRoute('app_forgot_password');
        }
        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dd($form['plainPassword']->getData());
            $user->setPassword($encoder->encodePassword($user, $form['password']->getData()))
                ->setForgotPasswordToken(null)
                ->setForgotPasswordTokenVerifiedDate(new \DateTimeImmutable('now'));

            $this->entityManager->flush();
            $this->removeCredentialsFromSession();
            $this->addFlash('success', 'Votre mot de passe a été modifié');
            return $this->redirectToRoute('app_login');
        }
        return  $this->render('reset-password/changePassword.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function getCredentialsFromSession(): array
    {
        return [
            'token' => $this->session->get('Reset-Password-Token-Url'),
            'email' => $this->session->get('Reset-Password-Token-Email')
        ];
    }
    private function isStillValid(\DateTimeImmutable $forgotPasswordToken): bool
    {
        return (new \DateTimeImmutable('now') > $forgotPasswordToken);
    }
    private function removeCredentialsFromSession()
    {
        $this->session->remove('Reset-Password-Token-Url');
        $this->session->remove('Reset-Password-Token-Email');
    }
}
