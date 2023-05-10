<?php

namespace App\Repository;

use App\Entity\Don;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Don>
 *
 * @method Don|null find($id, $lockMode = null, $lockVersion = null)
 * @method Don|null findOneBy(array $criteria, array $orderBy = null)
 * @method Don[]    findAll()
 * @method Don[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Don::class);
    }

    public function save(Don $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Don $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    /*
        public function findAlll($user)
        {
            return $this->createQueryBuilder('d')
                ->where('d.iduserdon = :user')
                ->setParameter('user', $user)
                ->orderBy('d.date', 'DESC')
                ->getQuery()
                ->getResult();
        }
    */
    /*
        public function findAllByUser($user)
        {
            return $this->createQueryBuilder('d')
                ->where('d.iduserdon = :user')
                ->setParameter('user', $user)
                ->orderBy('d.date', 'DESC')
                ->getQuery()
                ->getResult();
        }
    */
    public function findValidDon()
    {
        return $this->createQueryBuilder('d')
            ->where('d.etat = :valide')
            ->setParameter('valide', 1)
            ->orderBy('d.poids', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function poidsTotal()
    {
        return $this->createQueryBuilder('d')
            ->select('SUM(d.poids)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function total()
    {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function totaldonDispo()
    {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.etat = :valide')
            ->setParameter('valide', 1)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function poidsTotalparmois()
    {
        return $this->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->where('d.date = : mois'  )
            ->setParameter('mois', )
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function usersDon()
    {
        return $this->createQueryBuilder('d')
            ->select('User.nom AS utilisateur, SUM(d.poids) AS poids')
            ->leftJoin('d.iduserdon', 'User')
            ->groupBy('User.nom')
            ->getQuery()
            ->getResult();
    }

    public function categoriesdon ()
    {
        return $this->createQueryBuilder('d')
            ->select('c.nom AS categorie, COUNT(d.id) AS nombre')
            ->leftJoin('d.idCategorie', 'c')
            ->groupBy('c.nom')
            ->getQuery()
            ->getResult();

    }


    public function categoriesdons ()
    {
        return $this->createQueryBuilder('d')
            ->select('c.nom AS categorie, SUM(d.poids) AS poids')
            ->leftJoin('d.idCategorie', 'c')
            ->groupBy('c.nom')
            ->getQuery()
            ->getResult();

    }

    public function sumPoidsByUser ()
    {
        return $this->createQueryBuilder('d')
            ->select('u.nom AS user, SUM(d.poids) AS poids')
            ->leftJoin('d.iduserdon', 'u')
            ->groupBy('u.nom')
            ->orderBy('d.poids', 'DESC')
            ->getQuery()
            ->getResult();

    }

    /*
        public function findAll()
        {
            return $this->createQueryBuilder('d')
                ->where('d.etat = 1')
                ->setParameter('1', 1)
                ->orderBy('d.date', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult();
        }*/



    public function findByCategorie ($idCategorie)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.idCategorie = :idCategorie')
            ->setParameter('idCategorie', $idCategorie)
            ->getQuery()
            ->getResult();

    }
}
