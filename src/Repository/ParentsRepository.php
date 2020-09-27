<?php

namespace App\Repository;

use App\Entity\Parents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parents[]    findAll()
 * @method Parents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parents::class);
    }

        /**
     * Afficher la liste des parents
     */
    public function getAll() {
        $entityManager = $this->getEntityManager();
        // requête DQL : liste des enfants triés par prenom
        $query = $entityManager->createQuery(
            "SELECT p
                FROM App\Entity\Parents p
                ORDER BY p.prenom DESC"
        );
        return $query->execute();
    }

        /**
     * Afficher la liste des Parents appartenant a une famille
     */
    public function getAllByFamille($familles_id) {

        $entityManager = $this->getEntityManager();
        // requête DQL : liste des parents triés par nom
        $query = $entityManager->createQuery(
            "SELECT p
                FROM App\Entity\Parents p
                WHERE p.familles = :val
                ORDER BY p.nom DESC"     
        )
        ->setParameter('val', $familles_id);
        return $query->execute();
    }
    
    /**
     * recuperer un parent complet par rapport a son id
     */
    public function getOneByID($id): ?Parents
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    // /**
    //  * @return Parents[] Returns an array of Parents objects
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
    public function findOneBySomeField($value): ?Parents
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
