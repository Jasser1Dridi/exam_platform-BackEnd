<?php

namespace App\Repository;

use App\Entity\Candidat;
use App\Entity\Entrerpise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entrerpise>
 *
 * @method Entrerpise|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrerpise|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrerpise[]    findAll()
 * @method Entrerpise[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrerpiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrerpise::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Entrerpise $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Entrerpise $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Entrerpise[] Returns an array of Entrerpise objects
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
    public function findOneBySomeField($value): ?Entrerpise
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return Entrerpise[]
     */
    public function getAllEntreprise(): array
    {
        return $this->_em->createQueryBuilder()
            ->select('c')
            ->from('App\Entity\Entrerpise ', 'c') // Third parameter is index-by
            ->getQuery()
            ->getArrayResult();

    }
}
