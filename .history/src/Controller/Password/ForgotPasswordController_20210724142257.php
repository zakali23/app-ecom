<?php

namespace App\Controller\Password;


use DateTimeImmutable;
use App\Service\Mailer;
use App\Form\ForgotPasswordType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ForgotPasswordController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private SessionInterface $session;
    private UserRepository $userRepository;


    public function __construct(EntityManagerInterface $entityManager, SessionInterface $session, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->session = $session;
        $this->userRepository = $userRepository;
    }

    /**
     * send link with service email for changed password 
     * @Route("/{_locale}/forgot/password", name="app_forgot_password",methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function sendRecoveryLink(Request $request, Mailer $mailer, TokenGeneratorInterface $tokenGenerator)
    {
        $form = $this->createForm(ForgotPasswordType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // check email in database
            dd($form);
            $user = $this->userRepository->findOneBy([
                'email' => $form['email']->getData()
            ]);

            // if not register
            if (!$user) {
                $this->addFlash('success', 'Un email a été envoyé pour modifier votre mot de passe');
                return $this->redirectToRoute('app_login');
            }
            // if register
            $user->setForgotPasswordToken($tokenGenerator->generateToken())
                ->setForgotPasswordTokenRequestDate(new \DateTimeImmutable('now'))
                ->setForgotPasswordTokenMustBeVerifiedBefore(new DateTimeImmutable('+15 minutes'));

            $this->entityManager->flush();

            $mailer->sendEmail(
                $user->getFirstName(),
                $user->getLastName(),
                $user->getId(),
                $user->getEmail(),
                $user->getForgotPasswordToken()
            );
            $this->addFlash('success', 'Un email a été envoyé pour modifier votre mot de passe');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('reset-password/forgotPassword.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
