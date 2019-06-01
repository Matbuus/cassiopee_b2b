<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('date')
           #->add('client')
            ->add('localisation')
            ->add('typeEvenement')
            ->add('address')
            ->add('city')
            ->add('postal')
            ->add('lat',HiddenType::class)
            ->add('lng',HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
