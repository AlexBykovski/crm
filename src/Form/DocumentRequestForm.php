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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentRequestForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $userRole = $options["user_role"];

        /** @var DocumentRequest $document */
        $document = $builder->getData();

        $builder
            ->add('responsibleManager', TextType::class, [
                'required' => false,
                'label' => "Ответственный",
            ])
            ->add('budget', TextType::class, [
                'required' => false,
                'label' => "Бюджет",
            ])
            ->add('fio', TextType::class, [
                'required' => false,
                'label' => "ФИО клиента",
            ])
            ->add('issuedDate', DateType::class, [
                'required' => false,
                'label' => "Дата выдачи документа",
                'widget' => "single_text",
            ])
            ->add('issuedAuthority', TextType::class, [
                'required' => false,
                'label' => "Кем выдан документ",
            ])
            ->add('type', ChoiceType::class, [
                'required' => false,
                'label' => "Документ",
                'choices' => $this->getTypeChoices(),
            ])
            ->add('series', TextType::class, [
                'required' => false,
                'label' => "Серия документа",
            ])
            ->add('number', TextType::class, [
                'required' => false,
                'label' => "Номер документа",
            ])
            ->add('citizen', ChoiceType::class, [
                'required' => false,
                'label' => "Гражданство",
                'choices' => $this->getCitizenChoices(),
            ])
            ->add('birthPlace', TextType::class, [
                'required' => false,
                'label' => "Место рождения",
            ])
            ->add('birthDate', DateType::class, [
                'required' => false,
                'label' => "Дата рождения",
                'widget' => "single_text",
            ])
            ->add('term', ChoiceType::class, [
                'required' => false,
                'label' => "Срок регистрации",
                'choices' => $this->getTermChoices(),
            ])
            ->add('isBackDating', CheckboxType::class, [
                'required' => false,
                'label' => "Если задним числом",
            ])
            ->add('registerFrom', DateType::class, [
                'required' => false,
                'label' => "Срок регистрации с",
                'widget' => "single_text",
                'attr' => [
                    'readonly' => !$document->isBackDating(),
                ],
            ])
            ->add('registerTo', DateType::class, [
                'required' => false,
                'label' => "Срок регистрации по",
                'widget' => "single_text",
                'attr' => [
                    'readonly' => !$document->isBackDating(),
                ],
            ])
            ->add('status', ChoiceType::class, [
                'required' => false,
                'label' => "Статус",
                'choices' => $this->getStatusChoices($userRole),
            ])
            ->add('comment', TextareaType::class, [
                'required' => false,
                'label' => "Примечание",
            ])

            ->add('deliveryDetail', DeliveryDetailForm::class)
            ->add('documentDetail', DocumentDetailForm::class)
            ->add('submit', SubmitType::class, [
                'label' => "Готово"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocumentRequest::class,
            'validation_groups' => [],
            'user_role' => User::ROLE_MANAGER,
        ]);
    }

    protected function getTypeChoices()
    {
        return [
            "Паспорт" => "Паспорт",
            "Свидетельство о рождении" => "Свидетельство о рождении",
            "Вид на жительство" => "Вид на жительство",
            "Временное убежище" => "Временное убежище",
            "Другое" => "Другое",
        ];
    }

    protected function getCitizenChoices()
    {
        return [
            "Россия" => "Россия",
            "Украина" => "Украина",
            "Беларусь" => "Беларусь",
            "Казахстан" => "Казахстан",
            "Узбекистан" => "Узбекистан",
            "Туркменистан" => "Туркменистан",
            "Молдавия" => "Молдавия",
            "Таджикистан" => "Таджикистан",
            "Киргизия" => "Киргизия",
            "Армения" => "Армения",
            "Азербайджан" => "Азербайджан",
            "Другое" => "Другое",
        ];
    }

    protected function getTermChoices()
    {
        return [
            "3 месяца" => "3 месяца",
            "1 год" => "1 год",
            "3 года" => "3 года",
            "5 лет" => "5 лет",
        ];
    }

    protected function getStatusChoices($userRole)
    {
        switch ($userRole){
            case User::ROLE_MANAGER:
                return array_flip(DocumentRequest::MANAGER_STATUSES);
            case User::ROLE_PRINTER:
                return array_flip(DocumentRequest::PRINTER_STATUSES);
            case User::ROLE_LOGISTICIAN:
                return array_flip(DocumentRequest::LOGISTICIAN_STATUSES);
            default:
                return [];
        }
    }
}