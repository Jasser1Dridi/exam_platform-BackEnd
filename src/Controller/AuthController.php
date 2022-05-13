<?php

namespace App\Controller;

use App\Entity\Candidat;
use App\Entity\Entrerpise;
use App\Repository\CandidatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * The access point to this url will be:
 * http://localhost:4200
 * Access-Control-Allow-Origin: *

 */
class AuthController extends AbstractController
{
    private EntityManagerInterface $doctrine;
    private $candidat;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->candidat = new Candidat();
    }

    /**
     * @Route("auth/signUpCandidat",methods={"POST"})
     */
    public function SignUpCandidat(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $candidat = new Candidat();
    $candidat->setNom($parameters['name']);
        $candidat->setEmail($parameters['email']);
     $candidat->setPassword($parameters['password']);
      $candidat->setPhoneNumber($parameters['phoneNumber']);
      $candidat->setAdresse($parameters['adresse']);
      $candidat->setCin($parameters['cin']);
     $this->doctrine->persist($candidat);
       $this->doctrine->flush();
        return new Response(json_encode("saved successfully"), Response::HTTP_OK,headers_list());

    }
    /**
     * @Route("auth/signUpEntreprise",methods={"POST"})
     */
    public function SignUpEntreprise(Request $request): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $entreprise = new Entrerpise();
        $entreprise->setNom($parameters['name']);
        $entreprise->setEmail($parameters['email']);
        $entreprise->setPassword($parameters['password']);
        $entreprise->setPhoneNumber($parameters['phoneNumber']);
        $entreprise->setAdresse($parameters['adresse']);
        $entreprise->setDomaine($parameters['domaine']);
        $this->doctrine->persist($entreprise);
        $this->doctrine->flush();

        return new Response(json_encode("saved successfully"), Response::HTTP_OK,headers_list());

    }



    /**
     * @Route("auth/signIn",methods={"GET"})

     */
    public function SignIn(Request $request): Response
    {
        $username=$request->get('email');
        $password=$request->get('password');

        $qb=$this->doctrine->createQueryBuilder() ;
        $qb->select("u")->from('App\Entity\User',"u")->where("u.email = ?1")->andWhere("u.password= ?2")->setParameter('1',$username)->setParameter('2',$password);
        $q =$qb->getQuery()->getArrayResult();

        if($q != null)
        {
            return new JsonResponse(['state'=> true,'user'=>$q]);

        }
        else
        {
            return new JsonResponse(['state'=> false,'user'=>$q]);

        }



    }

    /**
     * @Route("auth/getCandidat",methods={"GET"})
     */
    public function getCandidat(): Response
    {
        $candidats = $this->doctrine->getRepository(Candidat::class)->findAll();
        foreach ($candidats as $candi) {
            $data[] = $this->candidat->serializeCandidat($candi);
        }
        return new Response(json_encode($data));
    }
}