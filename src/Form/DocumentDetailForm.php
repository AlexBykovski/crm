<?php

namespace App\Form;

use App\Entity\DeliveryDetail;
use App\Entity\DocumentDetail;
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

class DocumentDetailForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('street', TextType::class, [
                'required' => false,
                'label' => "Улица",
            ])
            ->add('district', TextType::class, [
                'required' => false,
                'label' => "Район",
            ])
            ->add('bossLastName', TextType::class, [
                'required' => false,
                'label' => "Фамилия начальника",
            ])
            ->add('department', TextType::class, [
                'required' => false,
                'label' => "Отделение",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocumentDetail::class,
            'validation_groups' => [],
        ]);
    }
}