<?php

namespace App\Form;

use App\Entity\DeliveryDetail;
use App\Entity\DocumentRequest;
use App\Entity\User;
use PhpParser\Comment\Doc;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DeliveryDetailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('deliveryDate', DateType::class, [
                'required' => false,
                'label' => "Дата доставки",
                'widget' => "single_text",
            ])
            ->add('deliveryTime', TimeType::class, [
                'required' => false,
                'label' => "Время доставки",
                'widget' => "single_text",
            ])
            ->add('address', TextType::class, [
                'required' => false,
                'label' => "Адрес доставки",
            ])
            ->add('station', TextType::class, [
                'required' => false,
                'label' => "Станция доствки",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DeliveryDetail::class,
            'validation_groups' => [],
        ]);
    }
}