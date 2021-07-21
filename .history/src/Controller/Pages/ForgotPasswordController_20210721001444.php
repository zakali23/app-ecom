<?php

namespace App\Controller\Pages;

use App\Service\Mailer;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class ForgotPasswordController extends AbstractController
{

    /**
     * @Route("/{_locale}/checkEmail", name="app_check_email")
     */
    public function index()
    {
        return $this->render('security/email.html.twig');
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

        dd($request);
    }
}
