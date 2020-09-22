<?php

namespace App\Repository;

use App\Entity\Galleries;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Galleries|null find($id, $lockMode = null, $lockVersion = null)
 * @method Galleries|null findOneBy(array $criteria, array $orderBy = null)
 * @method Galleries[]    findAll()
 * @method Galleries[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GalleriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Galleries::class);
    }

     /**
     * recuperer gallerie complette
     */
    public function getAll() {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT g
                FROM App\Entity\Galleries g
                ORDER BY g.creaDate DESC"
        );
        return $query->execute();
    }

         /**
     * recuperer gallerie complette si rgpd ok
     */
    public function getAllRgpd() {
        $qb = $this->createQueryBuilder('g')
         ->innerJoin ('g.enfants', 'e') 
         ->andWhere('e.rgpd = TRUE');

     return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return Galleries[] Returns an array of Galleries objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Galleries
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
