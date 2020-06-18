<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\CollectionPoint;
use App\Entity\Material;
use App\Entity\Objet;
use App\Repository\CategoryRepository;
use App\Repository\MaterialRepository;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                'required' => true,
            ])
            ->add('Material_id', EntityType::class, [
                'class' => Material::class,
                'label' => 'Matériaux',
                'query_builder' => function (MaterialRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name'
            ])
            ->add('Use_id', EntityType::class, [
                'class' => Category::class,
                'label' => 'Usage',
                'query_builder' => function (CategoryRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
        ]);
    }
}
