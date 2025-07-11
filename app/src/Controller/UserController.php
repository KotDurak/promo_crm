<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/dashboard/users')]
final class UserController extends AbstractController
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher,)
    {

    }

    #[Route('/', name: 'user_list')]
    #[IsGranted('ROLE_OWNER')]
    public function list(
        EntityManagerInterface $em,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $currentUser = $this->getUser();
        $queryBuilder = $em->getRepository(User::class)->createQueryBuilder('u');
        $queryBuilder->andWhere('u.organization = :org')
        ->setParameter('org', $currentUser->getOrganization());


        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('user/list.html.twig', [
            'pagination'    => $pagination,
        ]);
    }

    #[Route('/new', name: 'user_new')]
    #[IsGranted('ROLE_OWNER')]
    public function create(
        Request $request,
        EntityManagerInterface $em,
    )
    {
        $currentUser = $this->getUser();

        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['is_edit' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRole(User::ROLE_USER);
            $user->setOrganization($currentUser->getOrganization());
            $user->setPassword($this->passwordHasher->hashPassword($user, $user->getPassword()));
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/form.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Добавить сотрудника',
        ]);
    }

    #[Route('/edit/{id}', name: 'user_edit')]
    public function edit(
        int $id,
        Request $request,
        EntityManagerInterface $em,
    ): Response
    {
        $user = $em->getRepository(User::class)->find($id);
        $form = $this->createForm(UserType::class, $user, ['is_edit' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $plainPassword = $form->get('password')->getData();
            if ($plainPassword) {
                $user->setPassword(
                    $this->passwordHasher->hashPassword($user, $user->getPassword())
                );
            }

            $em->flush();

            return $this->isGranted('ROLE_OWNER')
                ? $this->redirectToRoute('user_list')
                : $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('user/form.html.twig', [
            'form'  => $form->createView(),
            'title' => 'Редактировать',
        ]);
    }

    #[Route('/delete/{id}', name: 'user_delete')]
    #[IsGranted('ROLE_OWNER')]
    public function delete(
        int $id,
        EntityManagerInterface $em
    ): Response
    {
        $user = $em->getRepository(User::class)->find($id);

        if (!$user) {
            throw $this->createNotFoundException('Пользователь не найден');
        }

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('user_list');
    }
}
