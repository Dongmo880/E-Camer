<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
            if ($options['current_password_is_required']) {
                $builder
                    ->add('currentPassword', PasswordType::class, [
                        'label' => 'Votre mot de passe actuelle',
                        'attr' => [
                            'placeholder'=>'Merci de saisir votre mot de passe actuelle',
                            'autocomplete' => 'off'
                        ],
                        'constraints' => [
                            new NotBlank([
                                'message' => 'Svp entrer votre mot de passe actuelle',
                            ]),
                            //ensuite ca verifie automatiquement si c'est le mot de passe actuel en faisant
                            new UserPassword(['message' => 'Mot de passe actuelle incorrect'])
                        ]
                    ]);
            }
            $builder
            ->add('newPassword', RepeatedType::class, [
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
                    'label' => 'Votre nouveau mot de passe',
                    'attr'=>[
                        'placeholder'=>"Merci de saisir votre nouveau mot de passe"
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmez votre nouveau mot de passe ',
                    'attr'=>[
                        'placeholder'=>"Merci de confirmez  votre nouveau mot de passe"
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
            'current_password_is_required'=>false
        ]);
    }
}
