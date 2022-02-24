<?php

namespace App\Controller;

use App\Entity\Histoire;
use App\Classe\Search;
use App\Form\SearchType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HistoireController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/histoire', name: 'histoire')]
    public function index(): Response
    {
       $histoires = $this->entityManager->getRepository(Histoire::class)->findAll();
       
        return $this->render('histoire/index.html.twig', [
            'histoires' => $histoires
        ]);
    }
}
