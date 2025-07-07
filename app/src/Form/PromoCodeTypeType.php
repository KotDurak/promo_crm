<?php

namespace App\Form;

use App\Entity\PromoCodeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PromoCodeTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Название', 'required' => true])
            ->add('cashback', IntegerType::class, ['label' => '% кешбека', 'required' => true])
            ->add('type', TextType::class, [
                'label' => 'Тип (Уникальный ключ для отображения во внешнем API)',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PromoCodeType::class,
        ]);
    }
}
