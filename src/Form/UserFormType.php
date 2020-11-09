<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('first_name', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Insert your first name",
                ],
            ])
            ->add('last_name', TextType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => "Insert your last name"
                ],
            ])
            ->add('save', SubmitType::class)
            ->setAction("/user/settings")
            ->setMethod("POST");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'cascade_validation' => true,
            'csrf_protection' => false
        ]);

    }
}
