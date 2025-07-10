<?php

namespace App\Controller\Api;

use App\Entity\Organization;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/token')]
final class OrganizationTokenController extends AbstractController
{
    #[Route('/refresh', methods: ['POST'])]
    public function refresh(Request $request, EntityManagerInterface $em): Response
    {
        $token = $request->headers->get('X-API-TOKEN');
        $repository = $em->getRepository(Organization::class);
        $organization = $repository->findOneBy(['apiKey' => $token]);

        if (empty($organization)) {
            return new JsonResponse(['error' => 'Invalid token'], Response::HTTP_UNAUTHORIZED);
        }

        $organization->generateApiKey();
        $em->flush();

        return new JsonResponse([
            'token'         => $organization->getApiKey(),
            'expires_at'    => $organization->getApiKeyExpiredAt(),
        ]);
    }
}
