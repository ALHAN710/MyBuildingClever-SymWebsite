<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                $this->getConfiguration("Prénom (*)", "Votre Prénom SVP (Obligatoire)...")
            )

            ->add(
                'lastName',
                TextType::class,
                $this->getConfiguration("Nom (*)", "Votre Nom SVP (Obligatoire)...")
            )

            ->add(
                'email',
                EmailType::class,
                $this->getConfiguration("Email (*)", "Votre Adresse email (Obligatoire pour les Administrateur)...")

            )

            // ->add(
            //     'avatar',
            //     TextType::class,
            //     $this->getConfiguration("Avatar :", "Choose your avatar", [
            //         'required' => false
            //     ])
            // )

            ->add(
                'hash',
                PasswordType::class,
                $this->getConfiguration("Mot de Passe (*)", "Mot de Passe utilisateur")
            )

            ->add(
                'passwordConfirm',
                PasswordType::class,
                $this->getConfiguration("Confirmation Mot de Passe (*)", "Entrer à nouveau le mot de passe de l'uilisateur")
            )

            ->add(
                'countryCode',
                TextType::class,
                $this->getConfiguration("Code Tél (*)", "Code Téléphonique du Pays (ex: +237)")

            )

            ->add(
                'phoneNumber',
                TextType::class,
                $this->getConfiguration("N° Tél (*)", "Numéro de Téléphone SVP (Obligatoire)...")

            )

            ->add(
                'role',
                ChoiceType::class,
                [
                    'choices' => [
                        'UTILISATEUR'    => 'ROLE_USER',
                        'ADMINISTRATEUR' => 'ROLE_ADMIN'
                    ],
                    'label'    => 'Attribut'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
