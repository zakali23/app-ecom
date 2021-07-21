<?php

/**
 * Created by PhpStorm.
 * User: Zak
 * Date: 20/12/2020
 * Time: 01:51
 */

namespace App\Service;


class Mailer
{
    private $mailer;
    private $templating;

    public function __construct(\Swift_Mailer $mailer, Twig\Environment $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function sendEmail($firstName, $lastName, $email, $path)
    {
        $body = $this->templating->render('emails/forgot.html.twig', [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'path' => $path,

        ]);
        $message = (new \Swift_Message('infoContact'))
            ->setFrom($email)
            ->setTo($email)
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }
}
