<?php

namespace App\Form;

use App\Entity\CollectionPointType;
use App\Entity\Material;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du matériau'
                ])
            ->add('devenir', TextType::class, [
                'label' => 'Consigne de tri'
                ])
            ->add('collectionPointType', EntityType::class, [
                'class' => CollectionPointType::class,
                'label' => 'Type de point de Collecte',
                'choice_label' => 'type'
            ])
            ->add('picture', TextType::class, [
                'label' => 'Nom de la photo tel que dans le fichier public/assets/img: (ex: photo.jpg)'
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Material::class,
        ]);
    }
}
