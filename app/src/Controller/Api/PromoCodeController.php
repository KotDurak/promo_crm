<?php

namespace App\Controller\Api;

use App\Dto\PromoCodeDto;
use App\Entity\Organization;
use App\Entity\PromoCode;
use App\Repository\PromoCodeRepository;
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
    public function list(Request $request): JsonResponse
    {
        /**
         * @var Organization $organization
        */
        $organization = $this->getUser();

        $page = $request->query->getInt('page', 1);
        $limit = $request->query->get('limit', 10);
        $data = $this->promoCodeService->getPromoCodes($organization, $page, $limit);
        $result = array_map(fn(PromoCode $promoCode) => PromoCodeDto::toArray($promoCode), $data['items']);

        return new JsonResponse([
            'data' => $result,
            'pagination'    => [
                'total' => $data['total'],
                'limit' => $limit,
                'page'  => $page,
                'pages' => (int)ceil($data['total'] / $limit),
            ]
        ]);
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

    #[Route(
        '/{id}',
        requirements: ['id' => '\d+'],
        methods: ['GET']
    )]
    public function getPromoCode(PromoCode $promoCode): JsonResponse
    {
        $organization = $this->getUser();

        if ($promoCode->getOrganization() !== $organization) {
            return new JsonResponse(['error' => 'Promo code not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'data' => PromoCodeDto::toArray($promoCode),
        ]);
    }
}
