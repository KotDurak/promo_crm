<?php

namespace App\Dto;

use App\Entity\PromoCode;

class PromoCodeDto
{
    public static function toArray(PromoCode $promoCode): array
    {
        $type = $promoCode->getPromoCodeType();
        $user = $promoCode->getCreatedBy();

        return  [
            'id'    => $promoCode->getId(),
            'code'  => $promoCode->getCode(),
            'type' => [
                'name'      => $type->getName(),
                'type'      => $type->getType(),
                'cashback'  => $type->getCashback(),
            ],
            'createBy'  => [
                'id'      => $user->getId(),
                'name'  => $user->getName(),
            ]
        ];
    }
}
