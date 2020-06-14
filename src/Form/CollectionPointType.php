<?php

namespace App\Form;

use App\Entity\CollectionPoint;
use App\Entity\CollectionPointType as EntityCollectionPointType;
use Doctrine\DBAL\Types\FloatType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionPointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du point de collecte'
            ])
            ->add('streetNumber', NumberType::class, [
                'label' => 'Numéro de la voie'
            ])
            ->add('streetName', TextType::class,[
                'label'=> 'Nom de la voie'
            ])
            ->add('city', TextType::class,[
                'label'=> 'Ville'
                ])
            ->add('zipCode', TextType::class,[
                'label' => 'Code Postal'
            ])
            ->add('coordinateX', FloatType::class, [
                'label' => 'Coordonnées GPS latitude'
            ])
            ->add('coordinateY', FloatType::class, [
                'label' => 'Coordonnées GPS longitude'
            ])
            ->add('openingTime', TextType::class, [
                'label' => "Horaires d'ouverture"
            ])
            ->add('review', TextType::class, [
                'label' => 'Commentaires sur ce point de collecte'
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone'
            ])
            ->add('website', TextType::class, [
                'label' => 'Site Web'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email'
            ])
            ->add('collectionPointType', EntityType::class, [
                'class' => EntityCollectionPointType::class,
                'label' => 'Type de point de Collecte',
                'choice_label' => 'type'
            ])
            //->add('material_has_collectionPoint')
           // ->add('objet_has_collectionPoint')
            //->add('category_has_collectionPoint')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CollectionPoint::class,
        ]);
    }
}
