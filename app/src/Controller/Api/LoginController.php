<?php

namespace App\Controller\Api;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


final class LoginController extends AbstractController
{

    #[Route('/api/login')]
    public function index(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em
    ): Response
    {
        $data = $request->toArray();
        $email = $data['email'];
        $password = $data['password'];

        if (empty($email) || empty($password)) {
            return new JsonResponse(['error' => 'Неаравильно переданы данные'], Response::HTTP_BAD_REQUEST);
        }

        $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

        if (empty($user) || !$user->isOwner()) {
            return new JsonResponse(['error' => 'not found'], Response::HTTP_NOT_FOUND);
        }

        if (!$passwordHasher->isPasswordValid($user, $password)) {
            return new JsonResponse(['error' => 'not found'], Response::HTTP_NOT_FOUND);
        }

        $organization = $user->getOrganization();
        $organization->generateApiKey();
        $em->flush();

        return new JsonResponse([
            'token'         => $organization->getApiKey(),
            'expires_at'    => $organization->getApiKeyExpiredAt(),
        ]);
    }
}
