<?php

namespace App\Repository;

use App\Entity\Symshop;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Symshop>
 *
 * @method Symshop|null find($id, $lockMode = null, $lockVersion = null)
 * @method Symshop|null findOneBy(array $criteria, array $orderBy = null)
 * @method Symshop[]    findAll()
 * @method Symshop[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SymshopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Symshop::class);
    }

//    /**
//     * @return Symshop[] Returns an array of Symshop objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Symshop
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
