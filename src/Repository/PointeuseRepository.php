<?php

namespace App\Repository;

use App\Entity\Pointeuse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pointeuse|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pointeuse|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pointeuse[]    findAll()
 * @method Pointeuse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PointeuseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pointeuse::class);
    }

    /**
     * recuperer la liste des pointage appartenant un enfant
     */
    public function getAllByEnfantId($enfant_id) {

        $entityManager = $this->getEntityManager();
        // requête DQL : liste des pointage triés par date d'arrivée
        $query = $entityManager->createQuery(
            "SELECT p
                FROM App\Entity\Pointeuse p
                WHERE p.enfants = :val
                AND p.arrivee=(
                    SELECT MAX(po.arrivee) 
                    FROM App\Entity\Pointeuse po
                    WHERE po.enfants = :val)"
        )
        ->setParameter('val', $enfant_id);
        return $query->execute();
    }
    
    
    /**
     * recuperer la liste des pointage appartenant un parent
     */
    public function getAllByParentId($parent_id) {

        $entityManager = $this->getEntityManager();
        // requête DQL : liste des pointage triés par date d'arrivée
        $query = $entityManager->createQuery(
            "SELECT p
                FROM App\Entity\Pointeuse p
                WHERE p.parents = :val
                AND p.arrivee=(
                    SELECT MAX(po.arrivee) 
                    FROM App\Entity\Pointeuse po
                    WHERE po.parents = :val)"
        )
        ->setParameter('val', $parent_id);
        return $query->execute();
    }
    

    /**
     * recuperer la liste des pointage appartenant un effectif
     */
    public function getAllByEffectifId($effectif_id) {

        $entityManager = $this->getEntityManager();
        // requête DQL : liste des pointage triés par date d'arrivée
        $query = $entityManager->createQuery(
            "SELECT p
                FROM App\Entity\Pointeuse p
                WHERE p.effectifs = :val
                AND p.arrivee=(
                    SELECT MAX(po.arrivee) 
                    FROM App\Entity\Pointeuse po
                    WHERE po.effectifs = :val)"
        )
        ->setParameter('val', $effectif_id);
        return $query->execute();
    }

    /**
     * recuperer un pointage par rapport a une id_pointeuse
     */
    public function getPointeuseById($pointeuse_id) {

        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            "SELECT p
                FROM App\Entity\Pointeuse p
                WHERE p.id = :val"
        )
        ->setParameter('val', $pointeuse_id);
        return $query->execute();
    }


    // /**
    //  * @return Pointeuse[] Returns an array of Pointeuse objects
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
    public function findOneBySomeField($value): ?Pointeuse
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
