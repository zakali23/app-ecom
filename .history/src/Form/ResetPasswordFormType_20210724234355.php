<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ResetPasswordFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder'  => 'form.types.passwordType.first_options.placeholder',
                        'pattern'   => "/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/g",
                        'title'  => "Pour des raisons de securité, votre mot de passe doit contenir un majuscule, un chiffre "
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
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => array('novalidate' => 'novalidate')
        ]);
    }
}
