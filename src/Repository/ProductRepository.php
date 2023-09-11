<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Product[]
     */
    public function findLatestProducts(int $maxResults): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.publicationDate <= CURRENT_DATE()')
            ->orderBy('p.publicationDate', 'ASC')
            ->setMaxResults($maxResults)
            ->getQuery()
            ->getResult();
    }
}
