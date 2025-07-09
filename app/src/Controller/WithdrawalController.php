<?php

namespace App\Controller;

use App\Entity\Enum\Status;
use App\Entity\User;
use App\Entity\WithdrawalRequest;
use App\Form\WithdrawalTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping as ORM;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/withdrawal')]
#[IsGranted('ROLE_USER')]
final class WithdrawalController extends AbstractController
{
    #[Route('/', name: 'app_withdrawal')]
    public function index(): Response
    {
        return $this->render('withdrawal/index.html.twig', [
            'controller_name' => 'WithdrawalController',
        ]);
    }

    #[Route('/create', name: 'withdrawal_new', methods: ['GET', 'POST'])]
    public function createRequest(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $withdrawal = new WithdrawalRequest();
        $form = $this->createForm(WithdrawalTypeForm::class, $withdrawal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $withdrawal->setRequestingUser($user);
            $withdrawal->setStatus(Status::PENDING);

            if ($form->get('sum')->getData() > $user->getBalance()) {
                $this->addFlash('error', 'Недостаточно средств');

                return $this->redirectToRoute('withdrawal_new');
            }

            $em->persist($withdrawal);
            $em->flush();

            $this->addFlash('success', 'Заявка успешно создана');

            return $this->redirectToRoute('app_withdrawal');
        }

        return $this->render('withdrawal/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/list', name: 'user_withdrawals')]
    public function listUserRequests(
        Request $request,
        EntityManagerInterface $em,
        PaginatorInterface $paginator
    ): Response
    {
        $user = $this->getUser();
        $queryBuilder = $em->getRepository(WithdrawalRequest::class)
            ->createQueryBuilder('wr')
            ->andWhere('wr.requestingUser = :reqUser')
            ->orderBy('wr.id', 'DESC')
            ->setParameter('reqUser', $user)
            ->getQuery();

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('withdrawal/list_user.html.twig', [
            'pagination' => $pagination,
            'route_name'    => 'user_withdrawals',
        ]);
    }

    #[Route('/owner/list', name: 'owner_withdrawals')]
    #[IsGranted('ROLE_OWNER')]
    public function listAllRequests(
        Request $request,
        EntityManagerInterface $em,
        PaginatorInterface $paginator
    ): Response
    {
        $queryBuilder = $em->getRepository(WithdrawalRequest::class)
            ->createQueryBuilder('wr')
            ->leftJoin('wr.requestingUser', 'u')
            ->addSelect('u');

        $queryBuilder
            ->andWhere('u.organization = :org')
            ->setParameter('org', $this->getUser()->getOrganization());

        if ($status = $request->query->get('status')) {
            $queryBuilder->andWhere('wr.status = :status')
            ->setParameter('status', $status);
        }

        if ($requestingUserId = $request->query->getInt('requesting_user_id')) {
            $queryBuilder->andWhere('u.id = :userId')
                ->setParameter('userId', $requestingUserId);
        }

        if ($createdAtFrom = $request->query->get('created_from')) {
            $queryBuilder->andWhere('wr.createdAt >= :createdAtFrom')
                ->setParameter('createdAtFrom', new \DateTimeImmutable($createdAtFrom));
        }

        if ($createAtTo = $request->query->get('created_to')) {
            $queryBuilder->andWhere('wr.createdAt <= :createAtTo')
                ->setParameter('createAtTo', $createAtTo);
        }

        $queryBuilder->orderBy('wr.id', 'DESC');
        $query = $queryBuilder->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            20
        );

        $users = $em->getRepository(User::class)->findBy(['organization' => $this->getUser()->getOrganization()]);

        return $this->render('withdrawal/list_owner.html.twig', [
            'pagination' => $pagination,
            'route_name'    => 'owner_withdrawals',
            'statusesList'  => Status::getListForSelect(),
            'users'         => $users,
        ]);
    }

    #[Route('/cancel/{id}', name: 'withdrawal_cancel')]
    public function cancelRequest(
        WithdrawalRequest $withdrawalRequest,
        EntityManagerInterface $em,
    ): Response
    {
        $user = $this->getUser();
        if ($withdrawalRequest->getRequestingUser() !== $user || $withdrawalRequest->getStatus() !== Status::PENDING) {
            $this->addFlash('error', 'Невозможно отменить эту заявку.');
            return $this->redirectToRoute('user_withdrawals');
        }

        $withdrawalRequest->setStatus(Status::CANCELLED);
        $em->persist($withdrawalRequest);
        $em->flush();
        $this->addFlash('success', 'Заявка отменена');

        return $this->redirectToRoute('user_withdrawals');
    }
}
