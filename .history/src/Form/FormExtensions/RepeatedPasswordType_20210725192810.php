<?php

namespace App\Form\FormExtensions;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RepeatedPasswordType extends AbstractType
{
    public function getParent(): string
    {
        return RepeatedType::class;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault([
            
        ])
    }
}
