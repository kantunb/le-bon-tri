<?php

namespace App\Form;

use App\Entity\CollectionPoint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionPointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('streetNumber')
            ->add('streetName')
            ->add('city')
            ->add('zipCode')
            ->add('coordinateX')
            ->add('coordinateY')
            ->add('openingTime')
            ->add('review')
            ->add('phone')
            ->add('website')
            ->add('email')
            ->add('collectionPointType')
            ->add('material_has_collectionPoint')
            ->add('objet_has_collectionPoint')
            ->add('category_has_collectionPoint')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CollectionPoint::class,
        ]);
    }
}
