<?php

namespace App\Form\Module;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('background', FileType::class, [
                'label' => 'admin.module.background'
            ])
            ->add('title', TextType::class, [
                'label' => 'admin.module.title'
            ])
            ->add('text', TextareaType::class, [
                'label' => 'admin.module.title',
                'attr' => [
                    'class' => 'tinymce'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
