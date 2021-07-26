<?php

namespace App\Form\FormExtensions;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RepeatedPasswordType extends AbstractType
{
    public function getParent(): string
    {
        return RepeatedType::class;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault([
            'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder'  => 'form.types.passwordType.first_options.placeholder',
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'form.passwordType.not_blank',
                        ]),
                        new Length([
                            'min' => 8,
                            'minMessage' => 'form.passwordType.length.min',
                            // max length allowed by Symfony for security reasons
                            'max' => 255,
                            'maxMessage' => 'form.passwordType.length.max'
                        ]),
                        new Regex([
                            'pattern' => "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/",
                            'message' => "form.passwordType.regex"
                        ])
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder' => 'form.types.passwordType.second_options.placeholder'
                    ],
                ],
                'invalid_message' => 'form.passwordType.invalid_message',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
    }
}
