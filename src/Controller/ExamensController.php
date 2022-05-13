<?php

namespace App\Controller;

use App\Entity\CompagneExamen;
use App\Entity\Exam;
use App\Entity\Examen;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExamensController extends AbstractController
{

    private EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("/getAllExamens", methods={"GET"})
     */
    public function getAllExamens(): Response
    {
        $examen = $this->doctrine
            ->getRepository(Examen::class)
            ->findAll();

        $data = [];

        foreach ($examen as $exa)
        {
            $questions = $this->doctrine
                ->getRepository(Questionnaire::class)
                ->findBy(["examen" => $exa ]);
            $question=[];
            foreach ($questions as $q)
            {
                $question[]=
                    [
                        'id' => $q->getId(),
                        'question' =>$q->getQuestion(),
                        'domaine' => $q->getDomaine(),
                        'points' => $q->getPoints(),
                        'managedby' => $q->getManagedBy(),
                    ];

            }
            if($exa->getCompagneExamen() != null) {
                $data[] = [
                    'id' => $exa->getId(),
                    'name' => $exa->getName(),
                    'duration' => $exa->getDuration(),
                    'questions' => $question,
                    'compagneExamen' => $exa->getCompagneExamen()->getId()
                ];
            }
            else
            {
                $data[] = [
                    'id' => $exa->getId(),
                    'name' => $exa->getName(),
                    'duration' => $exa->getDuration(),
                    'questions' => $question,
                    'compagneExamen' => null
                    ];
            }
        }


        return new Response(json_encode($data));
    }

    /**
     * @Route("/getOneExamen/{id}", methods={"GET"})
     */
    public function getOneExamen(int $id): Response
    {
        $examen = $this->doctrine
            ->getRepository(Examen::class)
            ->getOneExamen($id);







        return new Response(json_encode($examen));
    }

    /**
     * @Route("saveExamen",methods={"POST"})
     */
    public function saveExamen(Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);
        $e = new Examen();
        $e->setName($parameters['name']);
        $e->setDuration($parameters['duration']);

        foreach($parameters['questions'] as $question)
        {
            if($question['selected']==true)
            {
                 $q= $this->doctrine
                    ->getRepository(Questionnaire::class)
                    ->find($question['id']);
                 $q->setExamen($e);
            }
        }


        $this->doctrine->persist($e);
        $this->doctrine->flush();
        $response = new Response( json_encode(array('result' => "saved")));

        $response->headers->set('Content-Type', 'application/json');




        return  $response;

    }



}
