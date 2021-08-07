<?php
/**
 * Created by PhpStorm.
 * User: Zak
 * Date: 07/08/2021
 * Time: 12:56
 */

namespace App\Security\Exceptions;


use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class EmailNotVerifiedException extends CustomUserMessageAuthenticationException
{
    public function __construct(
        string $message = "Ce compte ne contient pas un email verifié",
        array $messageData = [],
        int $code = 0,
        \Throwable $previous = null)
    {
        parent::__construct($message, $messageData, $code, $previous);
    }
}