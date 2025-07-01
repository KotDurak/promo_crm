<?php

namespace App\Controller;

use App\Services\TestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TestController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function testIndex(TestService $testService)
    {
        return $this->render('test/index.html.twig', [
            'run'   => $testService->run(),
        ]);
    }

    #[Route('/hello/{name}', name: 'hello')]
    public function hello(string $name)
    {
        return new Response('Hello ' .  $name);
    }

    #[Route('/simple', methods: ['GET'])]
    public function simple()
    {
        return new Response('Simple');
    }
}
