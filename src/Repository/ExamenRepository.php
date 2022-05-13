<?php

namespace App\Repository;

use App\Entity\Examen;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Examen>
 *
 * @method Examen|null find($id, $lockMode = null, $lockVersion = null)
 * @method Examen|null findOneBy(array $criteria, array $orderBy = null)
 * @method Examen[]    findAll()
 * @method Examen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Examen::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Examen $entity, bool $flush = true): void
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
    public function remove(Examen $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
    /**
    * @return Examen[] Returns an array of Entrerpise objects
    */
    public function getAllExamenOfComp(int $id): array
    {
        return $this->_em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Examen ', 'e')
            ->where('e.compagneExamen = :id')
         ->setParameter('id', $id)// Third parameter is index-by
          ->getQuery()
          ->getArrayResult();


         }

    /**
     * @return Examen[] Returns an array of Entrerpise objects
     */
    public function getOneExamen(int $id): array
    {
        return $this->_em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\Examen ', 'e')
            ->where('e.id = :id')
            ->setParameter('id', $id)// Third parameter is index-by
            ->getQuery()
            ->getArrayResult();


    }
    // /**

    //  * @return Examen[] Returns an array of Examen objects
    //  */
    /*
     *    return $this->_em->createQueryBuilder()
         ->select('e','q')
          ->from('App\Entity\Examen ', 'e')
           ->from('App\Entity\Questionnaire', 'q')
           ->where('e.Questinnaire = q.id')
        ->andwhere('e.compagneExamen = :id')

         ->setParameter('id', $id)// Third parameter is index-by
          ->getQuery()
          ->getArrayResult();
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
    public function findOneBySomeField($value): ?Examen
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
