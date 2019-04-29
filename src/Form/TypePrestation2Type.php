<?php

namespace App\Form;

use App\Entity\TypePrestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TypePrestation2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomType')
            ->add('description')
            ->add('tarifPublic')
            ->add('metier')
            ->add('typeEvent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => TypePrestation::class,
        ]);
    }
}
