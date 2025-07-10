<?php

namespace App\Controller\Api;

use App\Entity\PromoCode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/promo-codes')]
final class PromoCodeController extends AbstractController
{
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
}
