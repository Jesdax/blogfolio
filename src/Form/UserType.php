<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastname', TextType::class, ['label' => 'Nom *'])
            ->add('firstname', TextType::class, ['label' => 'Prénom *'])
            ->add('username', TextType::class, ['label' => 'Nom d\'utilisateur *'])
            ->add('email', RepeatedType::class, [
                'type' => EmailType::class,
                'first_options' => ['label' => 'Adresse E-Mail *'],
                'second_options' => ['label' => 'Confirmer Adresse E-Mail *'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe *'],
                'second_options' => ['label' => 'Confirmer Mot de passe *'],
            ])
            ->add('date_of_birth', DateType::class, [
                'label' => 'Date de naissance',
                'attr' => ['class' => 'datepicker'],
                'widget' => 'single_text',
                'format'=> 'dd/MM/yyyy',
            ])
            ->add('gender', ChoiceType::class, [
                'label' => 'Genre',
                'attr' => ['class' => 'gender'],
                'expanded' => false,
                'multiple' => false,
                'choices' => [
                    'Masculin' => '1',
                    'Féminin' =>  '0',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
