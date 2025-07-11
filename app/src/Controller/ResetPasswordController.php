<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

;

use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mime\Email;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;


final class ResetPasswordController extends AbstractController
{

    #[Route('/reset-password', name: 'app_reset_password')]
    public function index(
        Request                     $request,
        EntityManagerInterface      $em,
        MailerInterface             $mailer,
        UserPasswordHasherInterface $passwordHasher
    ): Response
    {

        if ($request->isMethod('POST')) {
            try {
                $email = $request->get('email');
                $user = $em->getRepository(User::class)->findOneBy(['email' => $email]);

                if (empty($user)) {
                    throw new UserNotFoundException('Пользователь не найден');
                }

                $newPassword = bin2hex(random_bytes(8));
                $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
                $user->setPassword($hashedPassword);
                $em->flush();

                $email = (new Email())
                    ->from('no-reply@promo-crm.com')
                    ->to($user->getEmail())
                    ->subject('Новый пароль в системе PROMO CRM')
                    ->text("Ваш новый пароль: $newPassword\n\nПожалуйтса, смените его после логина.");

                $mailer->send($email);
                $this->addFlash('success', 'Новый пароль отправлен вам на почту');

                return $this->redirectToRoute('app_login');
            } catch (\Exception $ex) {
                $this->addFlash('error', 'Ошибка во время сброса пароля');
            }
        }

        return $this->render('reset_password/index.html.twig', [
            'controller_name' => 'ResetPasswordController',
        ]);
    }
}
