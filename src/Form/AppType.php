<?php

namespace App\Form;

use App\Entity\Objet;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AppType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', [
                'choice_label' => 'name',
                'attr' => [
                     'class' => 'app-form-objet' 
                 ]
            ])
           // ->add('avoidProduction')
           // ->add('valide')
           // ->add('Material_id')
           // ->add('Use_id')
           // ->add('collectionPoints')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Objet::class,
        ]);
    }
}
