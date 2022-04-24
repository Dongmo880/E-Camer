<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'label'=>'Quel nom souhaitez-vous donner a votre adresse',
                'attr'=>[
                    'placeholder'=>'Nomez votre adresse'
                ]
            ])
            ->add('firstname',TextType::class,[
                'label'=>'Votre prénom',
                'attr'=>[
                    'placeholder'=>'Entrez votre prénom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label'=>'Votre Nom',
                'attr'=>[
                    'placeholder'=>'Entrer votre nom'
                ]
            ])
            ->add('company',TextType::class,[
                'label'=>'Votre société',
                'attr'=>[
                    'placeholder'=>'Nomez votre societé'
                ]
            ])
            ->add('country',CountryType::class,[
                'label'=>'Votre Pays',
                'attr'=>[
                    'placeholder'=>'Entrer le nom du pays'
                ]
            ])
            ->add('ComplementAdresss',TextType::class,[
                'label'=>'Complement adresse',
                'attr'=>[
                    'placeholder'=>'Complement Adresse'
                ]
            ])
            ->add('adresse',TextType::class,[
                'label'=>'Votre adresse',
                'attr'=>[
                    'placeholder'=>'Exemple : 08 Rue lucie aubrac'
                ]
            ])
            ->add('postal',NumberType::class,[
                'label'=>'Votre code postal',
                'attr'=>[
                    'placeholder'=>'Entrer le code postale'
                ]
            ])
            ->add('city',TextType::class,[
                'label'=>'Votre Ville',
                'attr'=>[
                    'placeholder'=>'Quel est ville'
                ]
            ])
            ->add('phone',TextType::class,[
                'label'=>"Votre Telephone",
                'attr'=>[
                    'placeholder'=>'0758469325'
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Valider',
                'attr'=>[
                    'class'=>'btn btn-info btn-block'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
