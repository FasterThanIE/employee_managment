<?php

namespace App\Form;

use App\Entity\Request;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewRequestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('start_date', DateType::class, [
                'placeholder' => [
                    'day' => intval(date('d')),
                    'month' => date('M')
                ],
                'years' => Request::getAllowedYears()
            ])
            ->add('end_date', DateType::class, [
                'placeholder' => [
                    'day' => intval(date('d', time()+86400)),
                    'month' => date('M')
                ],
                'years' => Request::getAllowedYears()
            ])
            ->add('category', ChoiceType::class, [
                'choices' => array_flip(Request::VALID_CATEGORIES),
            ])
            ->add('type', ChoiceType::class, [
                'choices' => array_flip(Request::VALID_TYPES)
            ])
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
