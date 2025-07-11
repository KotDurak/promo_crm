<?php

namespace App\Services;

use App\Entity\PromoCode;
use Doctrine\ORM\EntityManagerInterface;

class PromoCodeService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ){ }

    public function register(string $code)
    {
        /**
         * @var PromoCode $promoCode
        */
        $promoCode = $this->entityManager->getRepository(PromoCode::class)->findByCode($code);
        $promoCode->setRegisterCount($promoCode->getRegisterCount() + 1);
        $this->entityManager->flush();
    }

    public function purchase(string $code, float $sum): bool
    {
        /**
         * @var PromoCode $promoCode
         */
        $promoCode = $this->entityManager->getRepository(PromoCode::class)->findByCode($code);
        //TODO реализовать пополнгение баланса пользователю при покупке промокода

        $cashback = $promoCode->getPromoCodeType()->getCashback();
        $userCashback  = ($sum * $cashback) / 100;

        try {
            $this->entityManager->beginTransaction();

            $user = $promoCode->getCreatedBy();
            $user->setBalance(
                $user->getBalance() + $userCashback
            );

            $this->entityManager->flush();
            $this->entityManager->commit();

            return true;
        } catch (\Exception $ex) {
            $this->entityManager->rollback();

            return false;
        }
    }
}
