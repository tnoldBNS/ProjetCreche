<?php

namespace App\Repository;

use App\Entity\Enfants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enfants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enfants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enfants[]    findAll()
 * @method Enfants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnfantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enfants::class);
    }

        /**
     * Afficher la liste des enfants
     */
    public function getAll() {
        $entityManager = $this->getEntityManager();
        // requête DQL : liste des enfants triés par date de naissance
        $query = $entityManager->createQuery(
            "SELECT e
                FROM App\Entity\Enfants e
                ORDER BY e.dateNaissance DESC"
        );
        return $query->execute();
    }


            /**
     * Afficher la liste des enfants
     */
    public function getAllSiDepartNull() {
        $entityManager = $this->getEntityManager();
        // requête DQL : liste des enfants triés par date de naissance
        $query = $entityManager->createQuery(
            "SELECT e
                FROM App\Entity\Enfants e
                WHERE e.dateDepart >= :val
                OR e.dateDepart IS NULL
                ORDER BY e.dateNaissance DESC"
        )
        ->setParameter('val', date('Y-m-d'));
        return $query->execute();
    }


    
    /**
     * Afficher la liste des enfants appartenant a une famille
     */
    public function getAllByFamille($familles_id) {

        $entityManager = $this->getEntityManager();
        // requête DQL : liste des enfants triés par date de naissance
        $query = $entityManager->createQuery(
            "SELECT e
                FROM App\Entity\Enfants e
                WHERE e.familles = :val
                ORDER BY e.dateNaissance DESC"     
        )
        ->setParameter('val', $familles_id);
        return $query->execute();
    }

    // /**
    //  * @return Enfants[] Returns an array of Enfants objects
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
    public function findOneBySomeField($value): ?Enfants
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
