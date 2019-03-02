<?php

namespace App\Repository;

use App\Entity\PortailB2B;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PortailB2B|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortailB2B|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortailB2B[]    findAll()
 * @method PortailB2B[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortailB2BRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PortailB2B::class);
    }

    // /**
    //  * @return PortailB2B[] Returns an array of PortailB2B objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PortailB2B
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
