<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_OWNER')]
final class SwaggerController extends AbstractController
{
    #[Route('/documentation', name: 'app_swagger')]
    public function index(): Response
    {
        return $this->render('docs/index.html.twig');
    }


    #[Route('/documentation/swagger.json')]
    public function getSwagger(): Response
    {
        $path = $this->getParameter('kernel.project_dir') . '/swagger/swagger.json';
        return $this->file($path);
    }
}
