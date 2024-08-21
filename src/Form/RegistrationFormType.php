<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom', // Le label affiché en français
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom de famille',
                    ]),
                ],
            ])
        
            
            ->add('email')
            ->add('firstName', TextType::class, [
                'label' => 'Prénom', // Le label affiché en français
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom',
                    ]),
                ],
            ])
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit être au moins {{ limit }} caractèreres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'Utilisateur' => 'ROLE_USER',
            //         'Super Administrateur' => 'ROLE_SUP_ADMIN',
            //         'Administrateur' => 'ROLE_ADMIN',
            //     ],
            //     'expanded' => false,  // Pour utiliser un <select> plutôt que des cases à cocher
            //     'multiple' => true,   // Si l'utilisateur peut choisir plusieurs rôles
            //     'attr' => [
            //         'class' => 'form-control select2bs4',
            //     ],
            // ]);
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Super Administrateur' => 'ROLE_SUP_ADMIN',
                    'Administrateur' => 'ROLE_ADMIN',
                    'Client' => 'ROLE_CLIENT', 
                ],
                'expanded' => true,  // Utilise un <select> plutôt que des cases à cocher
                'multiple' => true,   // Permet de sélectionner plusieurs rôles
                'attr' => [
                    'class' => 'form-control select2bs4',  // Classes Bootstrap appliquées au <select>
                ],
                'label_attr' => [
                    'class' => 'form-label', // Classe Bootstrap appliquée au label
                ],
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
