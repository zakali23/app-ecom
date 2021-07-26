<?php

namespace App\Form\FormExtensions;

use Symfony\Component\Form\AbstractType;


class RepeatedType extends AbstractType
{
    public function getParent(): string
    {
        return RepeatedType::class;
    }
}
