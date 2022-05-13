<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Entity\Reponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReponseController extends AbstractController
{
    private EntityManagerInterface $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }
    /**
     * @Route("/getOnereponse/{id}", methods={"GET"})
     */
    public function getOneReponse(int $id): Response
    {
        $ident =(int) $id;

        $reponse = $this->doctrine
            ->getRepository(Reponse::class)
            ->getOneReponse( $ident);

        return new JsonResponse($reponse);

    }
}
