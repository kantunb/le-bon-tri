<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CollectionPointType;
use App\Entity\CollectionPointType as EntityCollectionPointType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('devenir')
            ->add('collectionPointType', EntityType::class, [
                'class' => CollectionPointType::class,
                'label' => 'Type de point de Collecte',
                'choice_label' => 'type'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
