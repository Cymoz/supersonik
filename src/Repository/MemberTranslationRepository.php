<?php

namespace App\Repository;

use App\Entity\MemberTranslation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MemberTranslation|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberTranslation|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberTranslation[]    findAll()
 * @method MemberTranslation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberTranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberTranslation::class);
    }

    // /**
    //  * @return MemberTranslation[] Returns an array of MemberTranslation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MemberTranslation
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
