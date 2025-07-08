<?php

namespace App\Form;

use App\Entity\PromoCode;
use App\Entity\PromoCodeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class PromoCodeTypeForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $organizationId = $options['organization_id'];

        $builder
            ->add('code', null, [
                'label' => 'Промокод',
                'attr'  => ['placeholder' => 'Введите уникальный код'],
            ])
            ->add('promoCodeType', EntityType::class, [
                'class' => PromoCodeType::class,
                'choice_label'  => function(PromoCodeType $promoCodeType) {
                    return $promoCodeType->getName() . ' (' . $promoCodeType->getCashback() . '%)';
                },
                'label'         => 'Тип промокода',
                'query_builder' => function  ($er) use ($organizationId) {
                    return $er->createQueryBuilder('t')
                        ->where('t.organization = :org')
                        ->setParameter('org', $organizationId);
                }
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PromoCode::class,
            'organization_id'   => null,
        ]);

        $resolver->addAllowedTypes('organization_id', 'int');
    }
}
