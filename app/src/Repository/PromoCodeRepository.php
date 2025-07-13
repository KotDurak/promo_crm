<?php

namespace App\Repository;

use App\Entity\Organization;
use App\Entity\PromoCode;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PromoCode>
 */
class PromoCodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PromoCode::class);
    }

    //    /**
    //     * @return PromoCode[] Returns an array of PromoCode objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?PromoCode
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }


    public function findByCode(string $code): ?PromoCode
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.promoCodeType', 'pt')
            ->leftJoin('p.createdBy', 'createBy')
            ->addSelect(['pt'])
            ->andWhere('p.code = :code')
            ->setParameter('code', $code)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function finnByOrganizationPaginated(Organization $organization, int $page, int $limit): array
    {
        $offset = ($page - 1) * $limit;
        return $this->createQueryBuilder('p')
            ->leftJoin('p.promoCodeType', 'type')
            ->leftJoin('p.createdBy', 'createdBy')
            ->addSelect('type')
            ->andWhere('p.organization = :org')
            ->setParameter('org', $organization)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countByOrganization(Organization $organization): int
    {
        return (int) $this->createQueryBuilder('p')
            ->select('count(p.id)')
            ->andWhere('p.organization = :org')
            ->setParameter('org', $organization)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function getReportForOwner(
        Organization $organization,
        \DateTimeImmutable $firstDate,
        \DateTimeImmutable $lastDate,
    ): QueryBuilder {
       return $this->createQueryBuilder('pc')
           ->select([
               'SUM(pp.cashback) as cashback',
               'SUM(pp.fullPrice) as fullPrice',
               'SUM(pp.fullPrice) - SUM(pp.cashback) as profit',
               'cb.name',
               'pc.code'
           ])
            ->join('pc.purchases', 'pp')
           ->join('pc.createdBy', 'cb')
           ->join('pc.organization', 'o')
           ->andWhere('pc.organization = :org')
           ->andWhere('pp.purchaseDate BETWEEN :firstDate AND :lastDate')
           ->groupBy('pc.id', 'cb.id')
           ->orderBy('profit', 'DESC')
           ->setParameter('org', $organization)
           ->setParameter('firstDate', $firstDate)
           ->setParameter('lastDate', $lastDate);
    }


    public function getReportForEmployee(
        User $user,
        \DateTimeImmutable $firstDate,
        \DateTimeImmutable $lastDate
    ): QueryBuilder {
        return $this->createQueryBuilder('pc')
            ->select([
                'SUM(pp.cashback) as cashback',
                'SUM(pp.fullPrice) as fullPrice',
                'cb.name',
                'pc.code'
            ])
            ->join('pc.purchases', 'pp')
            ->join('pc.createdBy', 'cb')
            ->andWhere('cb.id = :userId')
            ->andWhere('pp.purchaseDate BETWEEN :firstDate AND :lastDate')
            ->groupBy('pc.id', 'cb.id')
            ->setParameter('userId', $user->getId())
            ->setParameter('firstDate', $firstDate)
            ->setParameter('lastDate', $lastDate);
    }
}
