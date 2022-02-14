<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoireController extends AbstractController
{
    #[Route('/histoire', name: 'histoire')]
    public function index(): Response
    {
        return $this->render('histoire/index.html.twig', [
            'controller_name' => 'HistoireController',
        ]);
    }
}
