<?php

namespace App\Repository;

use App\Entity\Effectifs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Effectifs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Effectifs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Effectifs[]    findAll()
 * @method Effectifs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EffectifsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Effectifs::class);
    }

    /**
     * Afficher la liste des effectifs
     */
    public function getAll() {
        $entityManager = $this->getEntityManager();
        // requête DQL : liste des effectifs triés par ordre alphabetique du prenom
        $query = $entityManager->createQuery(
            "SELECT e
                FROM App\Entity\Effectifs e
                ORDER BY e.prenom DESC"
        );
        return $query->execute();
    }

    
    public function getOneByIdUser($user_id): ?Effectifs
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.Users = :val')
            ->setParameter('val', $user_id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
    // /**
    //  * @return Effectifs[] Returns an array of Effectifs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Effectifs
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
