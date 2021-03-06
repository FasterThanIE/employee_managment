<?php

namespace App\Form;

use App\Entity\Request;
use DateTime;
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
                'years' => Request::getAllowedYears(),
                'data' => new DateTime(),
                'widget' => 'single_text',
            ])
            ->add('end_date', DateType::class, [
                'years' => Request::getAllowedYears(),
                'data' => new DateTime("+1 day"),
                'widget' => 'single_text'
            ])
            ->add('category', ChoiceType::class, [
                'choices' => array_combine(Request::VALID_CATEGORIES, Request::VALID_CATEGORIES),
            ])
            ->add('type', ChoiceType::class, [
                'choices' => array_combine(Request::VALID_TYPES, Request::VALID_TYPES),
            ])
            ->add('save', SubmitType::class)
            ->setAction('/requests')
            ->setMethod("POST");
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Request::class,
        ]);
    }
}
