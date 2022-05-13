<?php

namespace App\Repository;

use App\Entity\Examen;
use App\Entity\ExamenCandidatScore;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ExamenCandidatScore>
 *
 * @method ExamenCandidatScore|null find($id, $lockMode = null, $lockVersion = null)
 * @method ExamenCandidatScore|null findOneBy(array $criteria, array $orderBy = null)
 * @method ExamenCandidatScore[]    findAll()
 * @method ExamenCandidatScore[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExamenCandidatScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ExamenCandidatScore::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ExamenCandidatScore $entity, bool $flush = true): void
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
    public function remove(ExamenCandidatScore $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ExamenCandidatScore[] Returns an array of ExamenCandidatScore objects
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
    public function findOneBySomeField($value): ?ExamenCandidatScore
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
     * @return Examen[] Returns an array of Entrerpise objects
     */
    public function exist(int $idcandidat ): array
    {
        return $this->_em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\ExamenCandidatScore ', 'e')
            ->where('e.candidat = :idcan')
            ->setParameter('idcan',$idcandidat )// Third parameter is index-by

            ->getQuery()
            ->getArrayResult();


    }
    /**
     * @return Examen[] Returns an array of Entrerpise objects
     */
    public function done(int $idcandidat,int $examId ): array
    {
        return $this->_em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\ExamenCandidatScore ', 'e')
            ->where('e.candidat = :idcan')
            ->andWhere('e.examen= :idExam')
            ->setParameter('idcan',$idcandidat )// Third parameter is index-by
            ->setParameter('idExam',$examId)
            ->getQuery()
            ->getArrayResult();


    }
    /**
     * @return Examen[] Returns an array of Entrerpise objects
     */
    public function getallOfCom(int $idcandidat ): array
    {
        return $this->_em->createQueryBuilder()
            ->select('e')
            ->from('App\Entity\ExamenCandidatScore ', 'e')
            ->where('e.compagneExamen = :idcan')
            ->setParameter('idcan',$idcandidat )// Third parameter is index-by

            ->getQuery()
            ->getArrayResult();


    }
}
