<?php

namespace App\Controller;

use App\Entity\PromoCodeType;
use App\Entity\User;
use App\Form\PromoCodeTypeType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/dashboard/promo-code-type')]
#[IsGranted('ROLE_OWNER')]
final class PromoCodeTypeController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)  {}

    #[Route('/', name: 'app_promo_code_type')]
    public function index(Request $request, PaginatorInterface $paginator): Response
    {
        /**
         * @var User $user
        */
        $user = $this->getUser();
        $queryBuilder = $this->entityManager
            ->getRepository(PromoCodeType::class)
            ->createQueryBuilder('p')
            ->andWhere('p.organization = :org')
            ->setParameter('org', $user->getOrganization());

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('dashboard/promo_code_type/index.html.twig', [
            'pagination' => $pagination,
            'route_name' => 'app_promo_code_type',
        ]);
    }

    #[Route('/new', name: 'app_promo_code_type_new')]
    public function new(Request $request): Response
    {
        $currentUser = $this->getUser();
        $promoCode = new PromoCodeType();
        $form = $this->createForm(PromoCodeTypeType::class, $promoCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promoCode->setOrganization($currentUser->getOrganization());
            $this->entityManager->persist($promoCode);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_promo_code_type');
        }

        return $this->render('dashboard/promo_code_type/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Добавить тип промокода',
        ]);
    }

    #[Route('/edit/{id}', name: 'app_promo_code_type_edit')]
    public function edit(int $id, Request $request)
    {
        $promoCode = $this->entityManager->getRepository(PromoCodeType::class)->find($id);

        if (!$promoCode || $promoCode->getOrganization() !== $this->getUser()->getOrganization()) {
            throw $this->createNotFoundException('Тип не найден или доступ запрещен');
        }

        $form = $this->createForm(PromoCodeTypeType::class, $promoCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->redirectToRoute('app_promo_code_type');
        }


        return $this->render('dashboard/promo_code_type/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Редактировать тип промокода',
        ]);
    }


    #[Route('/delete/{id}', name: 'app_promo_code_type_delete')]
    public function delete($id): Response
    {
        $promoCode = $this->entityManager->getRepository(PromoCodeType::class)->find($id);
        if (!$promoCode || $promoCode->getOrganizationId() !== $this->getUser()->getOrganization()->getId()) {
            throw $this->createNotFoundException('Тип не найден или доступ запрещен');
        }

        $this->entityManager->remove($promoCode);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_promo_code_type');
    }
}
