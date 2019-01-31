<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchDocumentForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateFrom', DateType::class, [
                'required' => false,
                'widget' => "single_text",
                'label' => false,
                'attr' => [
                    'placeholder' => "Дата c",
                ],
            ])
            ->add('dateTo', DateType::class, [
                'required' => false,
                'widget' => "single_text",
                'label' => false,
                'attr' => [
                    'placeholder' => "Дата по",
                ],
            ])
            ->add('text', TextType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => "Поиск по клиентам",
                ],
            ])
            ->add('submit', SubmitType::class, [])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => null,
            'validation_groups' => [],
        ]);
    }
}