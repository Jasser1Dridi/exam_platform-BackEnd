<?php

namespace App\Controller;

use App\Entity\CompagneExamen;
use App\Entity\Exam;
use App\Entity\Examen;
use App\Entity\Questionnaire;
use App\Repository\CompagneExamenRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CompagneExamenController extends AbstractController
{

    private EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("getAllCompagneExamen",methods={"GET"})
     */
    public function getAllCompagneExamen(): Response
    {

        $repo = $this->doctrine
            ->getRepository(CompagneExamen::class);
       $questions= $repo->getAllComp();

        $response = new Response(json_encode($questions) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("getAllCompagneExamenDoctrine",methods={"GET"})
     */
    public function getAllCompagneExamenDoctrine(): Response
    {

        $repo = $this->doctrine
            ->getRepository(CompagneExamen::class);
        $compagneExamen= $repo->findAll();

        $response = new Response(json_encode($questions) );
        foreach ($compagneExamen as $exa)
        {

        }


        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("saveCompagneExamen",methods={"POST"})
     * @throws \Exception
     */
    public function saveCompagneExamen(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);

     $CompagneExamen = new CompagneExamen();
     $CompagneExamen->setName($parameters['name']);

        $CompagneExamen->setStartDate($parameters['startDate']);
         $CompagneExamen->setEndDate($parameters['endDate']);

         foreach ( $parameters['examens']  as $exmen )
         {
             $q= $this->doctrine
                 ->getRepository(Examen::class)
                 ->find($exmen['id']);
             $q->setCompagneExamen($CompagneExamen);


         }
        $response = new Response( json_encode(array('result' => "saved")));

        $this->doctrine->persist($CompagneExamen);
        $this->doctrine->flush();

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    /**
     * @Route("getAllExamesOfCompagne/{id}",methods={"GET"})
     */
    public function getAllExamesOfCompagne(string $id): Response
    {
        $ident =(int) $id;

        $exam = $this->doctrine->getRepository(Examen::class)->getAllExamenOfComp($id);


        $data=[];
        foreach ($exam as $q)
        {
            $pointTotal=0;
            $questionTotal=0;
            $questions= $this->doctrine
                ->getRepository(Questionnaire::class)
                ->getAllQofE($q['id']);
            foreach ($questions as $question)
            {
                $questionTotal++;
             $pointTotal+=$question['points'];
            }
            $q['questions']=$questions;
            $q['pointTotal']=$pointTotal;
            $q['questionTotal']=$questionTotal;

            $data[] = $q;



        }



        return new JsonResponse($data);
    }

    /**
     * @Route("getAllExamesOfCompagneExamens/{id}",methods={"GET"})
     */
    public function getAllExamesOfc(string $id): Response
    {
        $questions= $this->doctrine
            ->getRepository(Questionnaire::class)
            ->getAllQofE($id);

        return new JsonResponse($questions);


    }

    /**
     * @Route("getOneCompagne/{id}",methods={"GET"})
     */
    public function getOneCompagne(string $id): Response
    {
        $questions= $this->doctrine
            ->getRepository(CompagneExamen::class)
            ->getOneCompange($id);

        return new JsonResponse($questions);


    }
    }
