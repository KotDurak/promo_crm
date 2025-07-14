<?php

namespace App\Controller;

use App\Entity\PromoCode;
use App\Form\PromoCodeTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard')]
final class PromoCodeController extends AbstractController
{
    #[Route('/promo/code', name: 'app_promo_code')]
    public function index(
        Request $request,
        PaginatorInterface $paginator,
        EntityManagerInterface $em
    ): Response
    {
        $user = $this->getUser();
        $queryBuilder = $em->getRepository(PromoCode::class)
            ->createQueryBuilder('p')
            ->leftJoin('p.promoCodeType', 't')
            ->addSelect('t')
            ->where('p.createdBy = :user')
            ->setParameter('user', $user);

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('promo_code/index.html.twig', [
            'pagination'    => $pagination,
            'route_name'    => 'app_promo_code',
        ]);
    }

    #[Route('/promo/code/new', name: 'app_promocode_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $promoCode = new PromoCode();
        $user = $this->getUser();

        $form = $this->createForm(PromoCodeTypeForm::class, $promoCode, [
            'organization_id' => $user->getOrganization()->getId(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $promoCode->setCreatedBy($user);
            $promoCode->setOrganization($user->getOrganization());
            $em->persist($promoCode);
            $em->flush();

            return $this->redirectToRoute('app_promo_code');
        }

        return $this->render('promo_code/form.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Создать промокод'
        ]);
    }

    #[Route('/promo/code/edit/{id}', name: 'app_promocode_edit')]
    public function edit(PromoCode $promoCode, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if ($promoCode->getCreatedBy() !== $user) {
            throw $this->createAccessDeniedException('Вы не можете редактировать этот промокод.');
        }


        $form = $this->createForm(PromoCodeTypeForm::class, $promoCode, [
            'organization_id' => $user->getOrganization()->getId(),
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_promo_code');
        }

        return $this->render('promo_code/form.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Редактировать промокод',
            'promoLink' =>  $promoCode->getLinkForPromo(),
        ]);
    }

    #[Route('/promo/code/delete/{id}', name: 'app_promocode_delete')]
    public function delete(PromoCode $promoCode, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();

        if ($user !== $promoCode->getCreatedBy()) {
            throw $this->createAccessDeniedException('Вы не можете редактировать этот промокод.');
        }

        $em->remove($promoCode);
        $em->flush();

        return $this->redirectToRoute('app_promo_code');
    }
}
