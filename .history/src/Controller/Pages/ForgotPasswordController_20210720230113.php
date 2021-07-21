<?php

namespace App\Controller\Pages;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ForgotPasswordController extends AbstractController
{
    /**
     * @param Request $request
     * @param UserRepository $repository
     * @param Mailer $mailer
     * @param SerializerInterface $serializer
     * @param JWTTokenManagerInterface $JWTManager
     * @param JWTEncoderInterface $encoder
     * @return Response
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     * @Route("/api/{_locale}/forgotpassword", name="forgot_password",methods={"POST"})
     */
    public function __invoke(Request $request, UserRepository $repository, Mailer $mailer, SerializerInterface $serializer, JWTTokenManagerInterface $JWTManager, JWTEncoderInterface $encoder)
    {
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
            $resp = $serializer->serialize($msg, 'json');
            $response = new Response($resp);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        $resp = $serializer->serialize("votre email n'existe pas", 'json');
        $response = new Response($resp, Response::HTTP_CONFLICT);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
