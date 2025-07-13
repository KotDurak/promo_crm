<?php

namespace App\Controller;

use App\Services\Reports\PromoCodeStatistic;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(PromoCodeStatistic $promoCodeStatistic): Response
    {
        $promoCodes = $promoCodeStatistic->getDashboardStat($this->getUser());
        $promoCodesTotals = $promoCodeStatistic->getTotalsForDashboard($this->getUser());
        $promoCodeView = $this->getUser()->isOwner()
            ? 'dashboard/partials/owner-promocode-stat.html.twig'
            : 'dashboard/partials/employee-promocode-stat.html.twig';

        return $this->render('dashboard/index.html.twig', [
            'promoCodes' => $promoCodes,
            'promoCodeView' => $promoCodeView,
            'promoCodesTotals'  => $promoCodesTotals,
        ]);
    }
}
