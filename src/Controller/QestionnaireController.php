<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\CompagneExamen;
use App\Entity\Entrerpise;
use App\Entity\Examen;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class QestionnaireController extends AbstractController
{

    private EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @Route("saveQuestion",methods={"POST"})
     */
    public function saveQuestion(Request $request): Response
    {

        $parameters = json_decode($request->getContent(), true);
        $question = new Questionnaire();
        $question->setQuestion($parameters['questionName']);
        $question->setPoints($parameters['points']);
        $question->setDomaine($parameters['domaine']);
        $question->setManagedBy($parameters['managedby']);

        $reponses=$parameters['reponses'];
            foreach ($reponses as $rep) {
                $reponse = new Reponse();
                $reponse->setReponse($rep['reponse']);
                $reponse->setIstrue($rep['isTrue']);
                $question->addReponse($reponse);
            }

        $response = new Response( json_encode(array('result' => "saved")));

            $this->doctrine->persist($question);
            $this->doctrine->flush();

        $response->headers->set('Content-Type', 'application/json');




        return  $response;

    }
    /**
     * @Route("getAllQuestionsOfExames/{id}",methods={"GET"})
     */
    public function getAllQuestionOfExamen(string $id): Response
    {
          $ident =(int) $id;

        $questions = $this->doctrine
            ->getRepository(Questionnaire::class)
            ->findby(['examen'=> $ident]);

        $data = [];
        foreach ($questions as $q)
        {

                $data[] = [
                    'id' => $q->getId(),
                    'question' =>$q->getQuestion(),
                    'domaine' => $q->getDomaine(),
                    'points' => $q->getPoints(),
                    'managedby' => $q->getManagedBy(),
                    'examen' => $id,
                ];
            }



        return new JsonResponse($data);
    }

    /**
     * @Route("getAllQuestionsAndReponsesOfExames/{id}",methods={"GET"})
     */
    public function getAllQuestionsAndReponsesOfExames(string $id): Response
    {
        $ident =(int) $id;

        $questions = $this->doctrine
            ->getRepository(Questionnaire::class)
            ->findby(['examen'=> $ident]);

        $data = [];

        foreach ($questions as $q)
        {
            $reponses = $this->doctrine
                ->getRepository(Reponse::class)
                ->getReponses( $q->getId());

            $data[] = [
                'id' => $q->getId(),
                'question' =>$q->getQuestion(),
                'domaine' => $q->getDomaine(),
                'points' => $q->getPoints(),
                'managedby' => $q->getManagedBy(),
                'reponses'=> $reponses,
                'examen' => $id
            ];


        }



        return new JsonResponse($data);
    }
    /**
     * @Route("getAllQuestions",methods={"GET"})
     */
    public function getAllQuestions(SerializerInterface $serializer): Response
    {

        $questions = $this->doctrine
            ->getRepository(Questionnaire::class)
            ->findAll();

        $data = [];

        foreach ($questions as $q) {
            $rep = $this->doctrine
                ->getRepository(Reponse::class)
                ->findBy(["questionnaire" => $q ]);

            $reponses=[];
            foreach ($rep as $r)
            {
                $reponses[]=
                    [
                        'id'=>$r->getId(),
                        'reponse'=>$r->getReponse(),
                        'isTrue'=>$r->getIsTrue()
                    ];
            }
            if($q->getExamen()==null)
            {


                $data[] = [
                'id' => $q->getId(),
                'question' =>$q->getQuestion(),
                'domaine' => $q->getDomaine(),
                'points' => $q->getPoints(),
                'managedby' => $q->getManagedBy(),
                'reponse'=> $reponses,
                'examen'=>null
            ];
        }
            else
            {
                $data[] = [
                    'id' => $q->getId(),
                    'question' =>$q->getQuestion(),
                    'domaine' => $q->getDomaine(),
                    'points' => $q->getPoints(),
                    'managedby' => $q->getManagedBy(),
                    'reponse'=> $reponses,
                    'examen'=>$q->getExamen()->getId()
                ];
            }
                }


        return new JsonResponse($data);
    }


    }
