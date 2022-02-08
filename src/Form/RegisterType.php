<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TypeTextType::class, [
            'label' => 'Votre prénom',
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'Votre prénom'
                ]
        ])
        ->add('lastname', TypeTextType::class, [
            'label' => 'Votre nom',
            'constraints' => new Length([
                'min' => 2,
                'max' => 30
            ]),
            'attr' => [
                'placeholder' => 'Votre nom'
                ]
        ])
        ->add('phone', TelType::class, [
            'label' => 'Votre téléphone',
            'attr' => [
                'placeholder' => 'Veuillez entrer votre numéro de téléphone'
            ]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Votre adresse E-mail',
            'constraints' => new Length([
                'min' => 2,
                'max' => 60
            ]),
            'attr' => [
                'placeholder' => 'Veuillez entrez votre adresse email'
                ]
        ])
        ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'invalid_message' => 'Le mot de passe est la confirmation doivent être identique.',
            'label' => 'Votre mot de passe',
            'required' => true,
            'first_options' => [
                'label' => 'Votre mot de passe',
                'attr' => [
                    'placeholder' => 'Entrer votre mot de passe.'
                    ]
            ],
            'second_options' => [
                'label' => 'Confirmer votre mot de passe',
                'attr' => [
                    'placeholder' => 'Confirmer votre mot de passe.'
                    ]
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => "S'inscrire"
        ])
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
