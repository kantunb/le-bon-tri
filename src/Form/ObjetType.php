<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CollectionPoint;
use App\Entity\Material;
use App\Entity\Objet;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObjetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom de l'objet", 
             //   'pattern' => "^[a-z0-9_-]{2,50}$"
            ])

            //->add('avoidProduction')
           // ->add('valide') 
            //BooleanType::class, [
             //   'value' => false
            //])
            // ->add('Material_id')
            // ->add('Use_id')
            //
            ->add('Material_id', EntityType::class, [
                'class' => Material::class,
                'label' => 'Matériaux',
                'choice_label' => 'name'
            ])
            ->add('Use_id', EntityType::class, [
                'class' => Category::class,
                'label' => 'Usage',
                'choice_label' => 'name',
              // 'multiple' => true,
              // 'expanded' => true

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
        ]);
    }
}
