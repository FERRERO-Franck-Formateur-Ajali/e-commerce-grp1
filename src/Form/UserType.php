<?php

namespace App\Form;

use App\Entity\User;
use App\Form\ClientType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newemail', EmailType::class, [
                'label' => $options['label_email'],
                'attr' => [
                    'placeholder' => $options['placeholder'],
                ],
                'required' => $options['required'],
            ])
            ->add('newpassword', PasswordType::class, [
                'label' => $options['label_password'],
                'attr' => [
                    'placeholder' => $options['placeholder'],
                ],
                'required' => $options['required'],
            ])
            ->add('client', ClientType::class, [
                'label_attr' => [
                    'style' => 'display:none',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'label_email' => null,
            'label_password' => null,
            'required' => null,
            'placeholder' => null,
        ]);
    }
}
