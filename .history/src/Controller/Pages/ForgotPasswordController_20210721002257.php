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

        $method = $request->getMethod();
        if ($method === "GET") {
            return $this->render('security/email.html.twig');
        } else {
            $data = json_decode($request->getContent());
            $user = $repository->findBy(['email' => $data->email]);
            $resp = "";
            if (count($user) > 0) {
                $payload = [

                    'exp' => time() + (60 * 60)
                ];
                $jwt = $JWTManager->createFromPayload($user[0], $payload);
                $path = 'http://localhost:3000/fr/password/' . $jwt;
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
}
