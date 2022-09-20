<?php

namespace App\Form;

use App\Entity\Message;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaV3Type;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrueV3;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'label.name',
                'attr' => [
                    'placeholder' => 'placeholder.name',
                    'class' => 'form-control'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'attr' => [
                    'placeholder' => 'placeholder.email',
                    'class' => 'form-control'
                ]
            ])
            ->add('subject', ChoiceType::class, [
                'label' => 'label.subject',
                'choices'  => [
                    'contact.subject_first' => 'Subject 1',
                    'contact.subject_second' => 'Subject 2',
                    'contact.subject_third' => 'Subject 3',
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'placeholder.subject',
                ]
            ])
            ->add('content', TextareaType::class, [
                'label' => 'label.message',
                'attr' => [
                    'placeholder' => 'placeholder.message',
                    'class' => 'form-control'
                ]
            ])
            ->add('recaptcha', EWZRecaptchaV3Type::class, array(
                'action_name' => 'contact',
                'constraints' => array(
                    new IsTrueV3()
                )
            ))
            ->add('submit', SubmitType::class, [
                'label' => 'label.submit',
                'attr' => [
                    'class' => 'btn'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Message::class,
        ]);
    }
}
