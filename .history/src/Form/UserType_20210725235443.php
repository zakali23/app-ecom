<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\FormExtensions\RepeatedPasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => ['placeholder' => 'form.types.emailType.placeholder'],
            ])
            ->add('password', RepeatedPasswordType::class)
            ->add('firstName', TextType::class, [
                'attr' => ['placeholder' => 'form.types.textType.firstName.placeholder']
            ])
            ->add('lastName', TextType::class, [
                'attr' => ['placeholder' => 'form.types.textType.lastName.placeholder']
            ])
            ->add('birthday', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
            ])
            ->add("phone", TelType::class, [
                'attr' => ['placeholder' => 'form.types.telType.phone.placeholder']
            ])
            ->add('address', TextType::class, [
                'attr' => ['placeholder' => 'form.types.telType.phone.placeholder']
            ])
            ->add('codeZip')
            ->add('city');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => array('novalidate' => 'novalidate')
        ]);
    }
}
