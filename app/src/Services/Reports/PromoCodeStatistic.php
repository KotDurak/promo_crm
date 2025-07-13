<?php

namespace App\Services\Reports;

use App\Entity\Organization;
use App\Entity\PromoCode;
use App\Entity\User;
use App\Repository\PromoCodeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PromoCodeStatistic
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private PaginatorInterface $paginator
    )
    {
    }

    public function getDashboardStat(User $user): PaginationInterface
    {
        return $this->paginator->paginate(
            $this->getQueryBuilderByUser($user), 1, 20
        );
    }

    public function getTotalsForDashboard(User $user)
    {
        $queryBuilder = $this->getQueryBuilderByUser($user);
        $totalStatSelect = $user->isOwner()
            ? [
                'SUM(pp.cashback) as cashback',
                'SUM(pp.fullPrice) - SUM(pp.cashback) as profit',
                'SUM(pp.fullPrice) as fullPrice'
            ]

            : [
                'SUM(pp.fullPrice) as fullPrice',
                'SUM(pp.cashback) as cashback'
            ];


        $queryBuilder->resetDQLPart('groupBy')
            ->resetDQLPart('orderBy')
            ->select($totalStatSelect)
        ->setMaxResults(1);

        return $queryBuilder->getQuery()->getSingleResult();
    }

    private function getQueryBuilderByUser(User $user): QueryBuilder
    {
         /**
         * @var PromoCodeRepository $repository
         */
        $repository = $this->entityManager->getRepository(PromoCode::class);
        $firstDate = new \DateTimeImmutable('first day of this month 00:00:00');
        $lastDate = new \DateTimeImmutable('last day of this month 23:59:59');

        return $user->isOwner() ? $repository->getReportForOwner(
            $user->getOrganization(),
            $firstDate,
            $lastDate,
        )
            : $repository->getReportForEmployee(
                $user,
                $firstDate,
                $lastDate
            );
    }
}
