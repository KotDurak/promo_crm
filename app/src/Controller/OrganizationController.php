<?php

namespace App\Controller;

use App\Entity\Organization;
use App\Entity\User;
use App\Form\OrganizationEditTypeForm;
use App\Form\OrganizationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;



final class OrganizationController extends AbstractController
{
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
    )
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    #[Route('/organization', name: 'app_organization')]
    public function index(): Response
    {
        return $this->render('organization/index.html.twig', [
            'controller_name' => 'OrganizationController',
        ]);
    }

    #[Route('/organization/create', name: 'create_organization')]
    public function create( Request $request): Response
    {
        $organization = new Organization();

        $form = $this->createForm(OrganizationType::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $owner = $organization->getOwner();
            $owner->setRole(User::ROLE_OWNER);
            $hashedPassword = $this->passwordHasher->hashPassword($owner, $owner->getPassword());
            $owner->setPassword($hashedPassword);
            $owner->setOrganization($organization);

            if (!$organization->getApiKey()) {
                $apiKey = bin2hex(random_bytes(16)); // 32 символа hex
                $organization->setApiKey($apiKey);
            }

            $this->entityManager->persist($organization);
            $this->entityManager->flush();

            $this->addFlash('success', 'Вы успешно создали организацию');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('organization/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/organization/edit', name: 'app_organization_settings')]
    #[IsGranted('ROLE_OWNER')]
    public function edit(Request $request,): Response
    {
        $organization = $this->entityManager
            ->getRepository(Organization::class)
            ->findOneBy(['owner' => $this->getUser()]);

        $form = $this->createForm(OrganizationEditTypeForm::class, $organization);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlash('success', 'Настройки организации сохранены');

            return $this->redirectToRoute('app_organization_settings');
        }

        return $this->render('organization/settings.html.twig', [
            'form'  => $form->createView()
        ]);
    }

    #[Route('/organization/regenerate-api-key', name: 'organization_regenerate_api_key', methods: ['POST'])]
    #[IsGranted('ROLE_OWNER')]
    public function regenerateApiKey(EntityManagerInterface $em, Request $request): JsonResponse
    {
        $submittedToken = $request->headers->get('X-CSRF-TOKEN') ?? $request->request->get('_token');

        if (!$this->isCsrfTokenValid('regenerate-api-key', $submittedToken)) {
            return $this->json(['success' => false, 'message' => 'Недействительный CSRF-токен'], 403);
        }

        $organization = $this->getUser()->getOrganization();

        // Генерируем новый случайный API ключ
        $newApiKey = bin2hex(random_bytes(32));
        $organization->setApiKey($newApiKey);
        $em->flush();

        return $this->json([
            'success' => true,
            'newApiKey' => $newApiKey
        ]);
    }

}
