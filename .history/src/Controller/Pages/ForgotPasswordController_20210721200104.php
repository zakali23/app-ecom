<?php

namespace App\Controller\Pages;

use App\Service\Mailer;
use App\Entity\Password;
use App\Form\PasswordType;
use App\Form\ChangePasswordType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ForgotPasswordController extends AbstractController
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param Request $request
     * @param UserRepository $repository
     * @param Mailer $mailer
     * @param SerializerInterface $serializer
     * @param JWTTokenManagerInterface $JWTManager
     * @param JWTEncoderInterface $encoder
     * @return Response
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     * @Route("/{_locale}/forgotpassword", name="forgot_password",methods={"POST","GET"})
     */
    public function forgotPassword(Request $request, UserRepository $repository, Mailer $mailer, SerializerInterface $serializer, JWTTokenManagerInterface $JWTManager, JWTEncoderInterface $encoder)
    {


        $method = $request->getMethod();
        $msg = '';
        if ($method === "GET") {
            return $this->render('security/email.html.twig', ['msg' => $msg]);
        } else {
            $email = $request->get('email');
            $user = $repository->findBy(['email' => $email]);
            if (count($user) > 0) {
                $payload = [

                    'exp' => time() + (60 * 60)
                ];
                $jwt = $JWTManager->createFromPayload($user[0], $payload);
                $path = "http://localhost:8000" . $this->router->generate('change_password', ['token' => $jwt]);
                $mailer->sendEmail($user[0]->getFirstName(), $user[0]->getLastName(), $user[0]->getEmail(), $path);
                $msg = 'un email à ete envoyer a votre adresse : ' . $user[0]->getEmail();
                return $this->render('security/email.html.twig', ['msg' => $msg]);
            } else {
                $msg = "Votre email : " . $user[0]->getEmail() . " n'existe pas";
                return $this->render('security/email.html.twig', ['msg' => $msg]);
            }
        }
        return $this->render('security/email.html.twig');
    }

    /**
     * ChangePassword
     *
     * @param  mixed $request
     * @param  mixed $encoder
     * @param  mixed $repository
     * @param  mixed $encoderPassword
     * @param string $token
     * @return Response
     * @Route("/{_locale}/changepassword/{token}", name="change_password",methods={"POST","GET"})
     */
    public function ChangePassword(Request $request, string $token, JWTEncoderInterface $encoder, UserRepository $repository, UserPasswordEncoderInterface $encoderPassword)
    {
        $method = $request->getMethod();
        $msg = '';
        if ($method === "GET") {
            $password = new Password();
            $form = $this->createForm(ChangePasswordType::class, $password);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
            }
            return $this->render('security/changePassword.html.twig', ['msg' => $msg, 'form' => $form->createView(),]);
        } else {
        }
    }
}
