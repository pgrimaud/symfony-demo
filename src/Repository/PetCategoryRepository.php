<?php

namespace App\Repository;

use App\Entity\PetCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PetCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method PetCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method PetCategory[]    findAll()
 * @method PetCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PetCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PetCategory::class);
    }

    // /**
    //  * @return PetCategory[] Returns an array of PetCategory objects
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
    public function findOneBySomeField($value): ?PetCategory
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
