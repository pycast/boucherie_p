<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CotelettesController extends AbstractController
{
    /**
     * @Route("/cotelettes", name="cotelettes")
     */
    public function index(): Response
    {
        return $this->render('cotelettes/index.html.twig', [
            'controller_name' => 'CotelettesController',
        ]);
    }
}
