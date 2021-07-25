<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder'  => 'PasswordType.first_options.placeholder'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'user.password.not_blank',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'user.password.length.min',
                            // max length allowed by Symfony for security reasons
                            'max' => 255,
                            'maxMessage' => 'user.password.length.max'
                        ]),
                    ]
                ],
                'second_options' => [
                    'attr' => [
                        'autocomplete' => 'new-password',
                        'placeholder'  => 'PasswordType.second_options.placeholder'
                    ],
                ],
                'invalid_message' => 'The password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
