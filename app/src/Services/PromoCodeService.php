<?php

namespace App\Services;

use App\Entity\Organization;
use App\Entity\PromoCode;
use App\Entity\PromoCodePurchase;
use App\Repository\PromoCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

        if (empty($promoCode)) {
            throw new NotFoundHttpException();
        }

        $promoCode->setRegisterCount($promoCode->getRegisterCount() + 1);
        $this->entityManager->flush();
    }

    public function purchase(string $code, float $sum): bool
    {
        /**
         * @var PromoCode $promoCode
         */
        $promoCode = $this->entityManager->getRepository(PromoCode::class)->findByCode($code);


        if (empty($promoCode)) {
            throw new NotFoundHttpException();
        }


        $cashback = $promoCode->getPromoCodeType()->getCashback();
        $userCashback  = ($sum * $cashback) / 100;

        try {
            $this->entityManager->beginTransaction();

            $user = $promoCode->getCreatedBy();
            $user->setBalance(
                $user->getBalance() + $userCashback
            );

            $promoCodePurchase = new PromoCodePurchase();
            $promoCodePurchase->setPromoCode($promoCode);
            $promoCodePurchase->setPromoCodeOwner($promoCode->getCreatedBy());
            $promoCodePurchase->setPurchaseDate(new \DateTime());
            $promoCodePurchase->setFullPrice($sum);
            $promoCodePurchase->setCashback($userCashback);
            $this->entityManager->persist($promoCodePurchase);

            $this->entityManager->flush();
            $this->entityManager->commit();

            return true;
        } catch (\Exception $ex) {
            $this->entityManager->rollback();

            return false;
        }
    }

    #[ArrayShape(['items' => "array", 'total' => "int"])]
    public function getPromoCodes(Organization $organization, int $page, int $limit): array
    {
        /**
         * @var PromoCodeRepository $repository
        */
        $repository = $this->entityManager->getRepository(PromoCode::class);
        $promoCodes = $repository->finnByOrganizationPaginated($organization, $page, $limit);
        $totalCount = $repository->countByOrganization($organization);

        return [
            'items' => $promoCodes,
            'total' => $totalCount,
        ];
    }
}
