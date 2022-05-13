<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\CompagneExamen;
use App\Entity\Entrerpise;
use App\Entity\ExamenCandidatScore;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Expr\Cast\Object_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class CandidatController extends AbstractController
{

    private EntityManagerInterface $doctrine;
    private MailerInterface $mailer;
    public function __construct(EntityManagerInterface $doctrine,MailerInterface $mailer)
    {
        $this->mailer=$mailer;
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/getEntreprise/{id}", name="app_candidat",methods={"GET"})
     */
    public function getEntreprise(string $id ): Response
    {
        $idCandidat= (int) $id;
        $repo = $this->doctrine
            ->getRepository(Entrerpise::class);
        $candidat= $repo->find($idCandidat);

        $response = new Response(json_encode($candidat) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/getcandidats", name="app_candidat")
     */
    public function getAllCandidats(): Response
    {

        $repo = $this->doctrine
            ->getRepository(Candidat::class);
        $questions= $repo->getAllCandidat();

        $response = new Response(json_encode($questions) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/getOneCandidat/{id}",methods={"GET"})
     */
    public function getOneCandidat(string $id): Response
    {
        $idCandidat=(int) $id;
        $repo = $this->doctrine
            ->getRepository(Candidat::class);
        $questions= $repo->getOneCandidat($idCandidat);

        $response = new Response(json_encode($questions) );



        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/addCandidats",methods={"PUT"})
     */
    public function addCandidat(Request $request): Response
    {


        $parameters = json_decode($request->getContent(), true);
        $repo = $this->doctrine
            ->getRepository(CompagneExamen::class);
        $compagne= $repo->find($parameters['compagneExamen']);
     foreach ($parameters['candidat'] as $q)
     {
         $repo1 = $this->doctrine
             ->getRepository(Candidat::class);
        $candidat= $repo1->find($q['id']);
         $compagne->addCondidatCompagneDeExaman( $candidat);
         $this->doctrine->persist($compagne);
         $this->doctrine->flush();
         $this->sendEmail( $this->mailer,$candidat,$parameters['compagneExamen']);
     }

        $response = new Response( json_encode(array('result' => "saved")));


        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/send",methods={"Get"})
     */
    public function sendEmail(MailerInterface $mailer, Candidat $candidat,int $examen): Response
    {
        $random = random_bytes(18);
        $codeUnique="http://localhost:4200/examined/".$candidat->getId()."-".$examen."-". $random;

        $email = (new Email())
            ->from('examensplatforme@gmail.com')
            ->to($candidat->getEmail())
            ->subject('Invitation pour passer des examens')
               ->html('<h2> Salut '.$candidat->getNom().' </h2> 
                <span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: black;">
                
Pour Passer Votre examen clique sur le lien dessus
 </span>
'.'<h1> <a style="font-family: Arial, Helvetica, sans-serif; font-size: 22px; color: #BBBBBB;"href=" '. $codeUnique.'">clique ici</a></h1>');
        $mailer->send($email);

        $response = new Response( json_encode(array('result' => "saved")));


        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    /**
     * @Route("/getcandidat/{id}", methods={"Get"})
     */
    public function getCandidat(string $id): Response
    {
         $CandidatId= (int) $id;
        $repo = $this->doctrine
            ->getRepository(Candidat::class);
        $candidat= $repo->find($CandidatId);


        $data=[
                'id'=>$candidat->getId(),
                'nom'=>$candidat->getNom(),

        ];
        $response = new Response(json_encode($data) );

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Route("/getCandidats/{id}", methods={"Get"})
     */
    public function getCandidats(string $id): Response
    {
        $CandidatId= (int) $id;
        $repo = $this->doctrine
            ->getRepository(ExamenCandidatScore::class);
        $candidats= $repo->findby(['compagneExamen'=>$CandidatId]);


        $data=[


        ];

        foreach ($candidats as $c)
        {
           $candidat= $this->doctrine
                ->getRepository(Candidat::class)
           ->getOneCandidat($c->getId());
           array_push( $data,$candidat);

        }
        $response = new Response(json_encode($data[0]) );

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
