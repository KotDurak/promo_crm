<?php

namespace App\Form;

use App\Entity\WithdrawalRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class WithdrawalTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sum', MoneyType::class, [
                'label' => 'Сумма вывода',
                'currency'  => 'RUB',
            ])
            ->add('cardNumber', TextType::class, [
                'label' => 'Номер карты',
                'required'  => false,
            ])
            ->add('phoneNumber', TextType::class, [
               'label'    => 'Номер телефона',
               'required' => false,
            ])
            ->add('comment', TextareaType::class, [
                'label' => 'Комментарий',
                'required'  => false,
                'attr'      => [
                    'placeholder' => 'Дополнительная информация, например уточните банк если заявка по номеру телефона'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WithdrawalRequest::class,
        ]);
    }
}
