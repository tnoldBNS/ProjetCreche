<?php

namespace App\Repository;

use App\Entity\Commissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Commissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commissions[]    findAll()
 * @method Commissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commissions::class);
    }

    /**
     * Afficher la liste des commissions
     */
    public function getAll() {
        $entityManager = $this->getEntityManager();
        // requête DQL : liste des commissions triés par ordre alphabetique
        $query = $entityManager->createQuery(
            "SELECT c
                FROM App\Entity\Commissions c
                ORDER BY c.nomCommission"
        );
        return $query->execute();
    }

    /**
     * Afficher les emails des patents en lien avec une commission
     */
    public function getAllEmailByCommission($commission_id) {
        $entityManager = $this->getEntityManager();
        
        $query = $entityManager->createQuery(
            "SELECT p.email
                FROM App\Entity\Parents p, App\Entity\Familles f, App\Entity\Enfants e, App\Entity\Commissions c
                WHERE p.familles = f.id
                AND f.id = e.familles
                AND e.commissions = c.id
                AND c.id = :val
                AND e.dateDepart >= :val1
                OR e.dateDepart IS NULL"     
        )
        ->setParameter('val', $commission_id)('val1')
        ->setParameter('val1', date('Y-m-d'));
        return $query->execute();
    }

    // /**
    //  * @return Commissions[] Returns an array of Commissions objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Commissions
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
