<?php

namespace App\Repository;

use App\Entity\CompagneExamen;
use App\Entity\Examen;
use App\Entity\Questionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<CompagneExamen>
 *
 * @method CompagneExamen|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompagneExamen|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompagneExamen[]    findAll()
 * @method CompagneExamen[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompagneExamenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CompagneExamen::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(CompagneExamen $entity, bool $flush = true): void
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
    public function remove(CompagneExamen $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return CompagneExamen[] Returns an array of CompagneExamen objects
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
    public function findOneBySomeField($value): ?CompagneExamen
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @return CompagneExamen[]
     */
    public function getAllComp(): array
    {
        return $this->_em->createQueryBuilder()
            ->select('c')
            ->from('App\Entity\CompagneExamen ', 'c') // Third parameter is index-by
            ->getQuery()
            ->getArrayResult();

    }

    /**
     * @return CompagneExamen[]
     */
    public function getOneCompange( int $id): array
    {
        return $this->_em->createQueryBuilder()
            ->select('c')
            ->from('App\Entity\CompagneExamen ', 'c') // Third parameter is index-by
            ->where('c.id='. $id)
            ->getQuery()
            ->getArrayResult();

    }

    /**
     * @return Questionnaire[]
     */
    public function getAllQuestionofExam(int $id): array
    {
        return $this->_em->createQueryBuilder()
            ->select('c',)
            ->from('App\Entity\Questionnaire ', 'c')->where('c.examen_id='. $id)// Third parameter is index-by
            ->getQuery()
            ->getArrayResult();

    }

}
