<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Entrerpise;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class EntrepriseController extends AbstractController
{

    private EntityManagerInterface $doctrine;
    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/getAllEntrprises", methods={"GET"})
     */
    public function getAllEntreprises(): Response
    {
        $repo = $this->doctrine
            ->getRepository(Entrerpise::class);
        $questions= $repo->getAllEntreprise();

        $response = new Response(json_encode($questions) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/getOneEntreprise/{id}",methods={"GET"})
     */
    public function getOneEntreprise(string $id): Response
    {
        $idEntreprise = (int) $id;
        $repo = $this->doctrine
            ->getRepository(Entrerpise::class);
        $entreprise= $repo->find($idEntreprise);

        $data[]=[
            'id'=>$entreprise->getId(),
            'nom'=>$entreprise->getNom(),
            'email'=> $entreprise->getEmail(),
            'phoneNumber'=>$entreprise->getPhoneNumber(),
            'adresse'=>$entreprise->getAdresse(),
            'domaine'=>$entreprise->getDomaine()
        ];

        $response = new Response(json_encode($data) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/Update/{id}",methods={"PUT"})
     */
    public function upDate(string $id,\Symfony\Component\HttpFoundation\Request $request): Response
    {
        $req = json_decode($request->getContent(),true);
      //  echo json_encode($req);
        $idEntreprise = (int) $id;
        $repo = $this->doctrine
            ->getRepository(Entrerpise::class);
        $entreprise= $repo->find($idEntreprise);

        $entreprise->setNom($req['nom']);
        $entreprise->setEmail($req['email']);
        $entreprise->setPhoneNumber($req['phoneNumber']);
        $entreprise->setAdresse($req['adresse']);
        $entreprise->setDomaine($req['domaine']);


        $this->doctrine->persist($entreprise);
        $this->doctrine->flush();

        $response = new Response(json_encode(['save'=>'sucessfully']) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/delete/{id}",methods={"DELETE"})
     */
    public function delete(string $id): Response
    {

        $idEntreprise = (int) $id;
        $repo = $this->doctrine
            ->getRepository(Entrerpise::class);
        $entreprise= $repo->find($idEntreprise);


        $this->doctrine->remove($entreprise);
        $this->doctrine->flush();

        $response = new Response(json_encode(['save'=>'sucessfully']) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("getAllQuestionsByAdmin",methods={"GET"})
     */
    public function getAllQuestionsByAdmin(SerializerInterface $serializer): Response
    {

        $questions = $this->doctrine
            ->getRepository(Questionnaire::class)
            ->findBy(['managedBy'=>'admin']);

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

    /**
     * @Route("/deleteQuestion/{id}",methods={"DELETE"})
     */
    public function deleteQuestion(string $id): Response
    {

        $idEntreprise = (int) $id;
        $repo = $this->doctrine
            ->getRepository(Questionnaire::class);
        $entreprise= $repo->find($idEntreprise);


        $this->doctrine->remove($entreprise);
        $this->doctrine->flush();

        $response = new Response(json_encode(['save'=>'sucessfully']) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
