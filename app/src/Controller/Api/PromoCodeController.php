<?php

namespace App\Controller\Api;

use App\Entity\PromoCode;
use App\Services\PromoCodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/promo-codes')]
final class PromoCodeController extends AbstractController
{
    public function __construct(
        private PromoCodeService $promoCodeService
    ) {}

    #[Route('/', methods: ['GET'])]
    public function list(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $organization = $this->getUser();

        $promoCodes = $em->getRepository(PromoCode::class)
            ->findBy(['organization' => $organization]);

        $result = array_map(static fn(PromoCode $pc) => [
            'id'    => $pc->getId(),
            'code'  => $pc->getCode(),
        ], $promoCodes);

        return new JsonResponse(['data' => $result]);
    }


    #[Route('/register', methods: ['POST'])]
    public function register(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['promo_code'])) {
            return new JsonResponse(['error' => 'empty promo code'], Response::HTTP_BAD_REQUEST);
        }
        $this->promoCodeService->register($data['promo_code']);

        return new JsonResponse([
            'code' => 0,
            'message' => 'OK'
        ]);
    }

    #[Route('/purchase', methods: ['POST'])]
    public function purchase(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['promo_code'])) {
            return new JsonResponse(['error' => 'empty promo code'], Response::HTTP_BAD_REQUEST);
        }

        if (empty($data['sum']) || $data['sum'] < 0) {
            return new JsonResponse(['error' => 'sym must be grater than 0'], Response::HTTP_BAD_REQUEST);
        }

        if ($this->promoCodeService->purchase($data['promo_code'], $data['sum'])) {
            return new JsonResponse(['code' => 0, 'message' => 'OK']);
        }

        return new JsonResponse(['code' => '1', 'message' => 'Cannot set cashback']);
    }
}
