<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('short_content')
            ->add('content')
            // ->add('createdAt')
            ->add('blog_has_tag', EntityType::class, [
                'class' => Tag::class,
                'multiple' => true,
                'choice_label' => 'name'
            ])
            // ->add('blog_has_tag', ChoiceType::class, [
            //     'class' => Tag::class,
            //     'multiple' => true,
            //     'choices' => 'blog_has_tag'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
