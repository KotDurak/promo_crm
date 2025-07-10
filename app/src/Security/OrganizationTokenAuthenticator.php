<?php

namespace App\Security;


use App\Repository\OrganizationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class OrganizationTokenAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(
        private EntityManagerInterface $em,
        private OrganizationRepository $orgRepo
    ){

    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-API-TOKEN');
    }

    public function authenticate(Request $request): Passport
    {
        $token = $request->headers->get('X-API-TOKEN');

        if (empty($token)) {
            throw new CustomUserMessageAuthenticationException('API token required');
        }

        $organization = $this->orgRepo->findOneBy(['apiKey' => $token]);

        if (!$organization) {
            throw new AuthenticationException('Invalid API Token');
        }

        if (!$organization->isValidApiKey()) {
            throw new AuthenticationException('Token expired', [
                'organization_id' => $organization->getId()
            ]);
        }


        return new SelfValidatingPassport(
            new UserBadge($organization->getApiKey(), fn() => $organization)
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): JsonResponse
    {
        $data = [
            'error' => str_replace(' ', '_', strtolower($exception->getMessage()))
        ];

        if ($exception->getMessage() === 'Token expired') {
            $data['organization_id'] = $exception->getMessageData()['organization_id'];
        }

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        return new JsonResponse([
            'error' => 'Authentication Required'
        ], 401);
    }
}
