<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Examen;
use App\Entity\ExamenCandidatScore;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScoreController extends AbstractController
{

    private EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/calculScore",methods={"POST"})
     */
    public function saveScore(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);


        $ExamenCandidatScore  = new ExamenCandidatScore();
        $ExamenCandidatScore->setCandidat( $parameters['candidatId']);
        $ExamenCandidatScore->setExamen($parameters['examenId']);
        $ExamenCandidatScore->setCandidatScore($parameters['score']);
        $ExamenCandidatScore->setCompagneExamen($parameters['compagneExamen']);

        $this->doctrine->persist($ExamenCandidatScore);
        $this->doctrine->flush();
        return new JsonResponse(true);

    }

    /**
     * @Route("/examFinished/{candidatId}",methods={"GET"})
     */
    public function examFinished(int $candidatId): Response
    {
        $exist = $this->doctrine
            ->getRepository(ExamenCandidatScore::class)
            ->exist( $candidatId);


            return new JsonResponse($exist);

    }

    /**
     * @Route("/doneit/{candidatId}/{examId}",methods={"GET"})
     */
    public function doneit(int $candidatId,int $examId): Response
    {
        $exist = $this->doctrine
            ->getRepository(ExamenCandidatScore::class)
            ->done( $candidatId,$examId);
        if(sizeof($exist) ==0)
        {
            return new JsonResponse(false);

        }
else {
    return new JsonResponse(true);
}
    }
    /**
     * @Route("/getAllscoreofCompagne/{comId}",methods={"GET"})
     */
    public function scoreCompagne(int $comId): Response
    {
        $exist = $this->doctrine
            ->getRepository(ExamenCandidatScore::class)
            ->getallOfCom( $comId);


        return new JsonResponse($exist);

    }
}
