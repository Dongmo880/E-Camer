<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class,[
                'label'=>'Votre prénom',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'votre prénom doit pas etre inferieure à {{limit}}',
                        // max length allowed by Symfony for security reasons
                        'max' => 32,
                    ]),
                ],
                'attr'=>[
                    'placeholder'=>"Merci de saisir votre prénom"
                ]
            ]) ->add('lastname',TextType::class,[
                'label'=>'Votre  nom',
                'constraints' => [
                    new Length([
                        'min' => 3,
                        'minMessage' => 'votre nom ne doit pas etre inferieure à {{limit}}',
                        // max length allowed by Symfony for security reasons
                        'max' => 32,
                    ]),
                ],
                'attr'=>[
                    'placeholder'=>"Merci de saisir votre nom"
                ]
            ])
            ->add('email',EmailType::class,[
                'label'=>'Votre email',
                'attr'=>[
                    'placeholder'=>"Merci de saisir votre email"
                ]
            ])
            ->add('password', RepeatedType::class, [
            'type' => PasswordType::class,
            'first_options' => [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe ne doit pas etre inferieure à {{limit}}',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
                'label' => 'Votre mot de passe',
                'attr'=>[
                    'placeholder'=>"Merci de saisir votre mot de passe"
                ]
            ],
            'second_options' => [
                'label' => 'Confirmez votre mot de passe ',
                'attr'=>[
                    'placeholder'=>"Merci de confirmez  votre mot de passe"
                ]
            ],
            'invalid_message' => 'les deux mots doivent etre identiques',
            'mapped' => false,
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
