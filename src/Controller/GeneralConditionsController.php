<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneralConditionsController extends AbstractController
{
    #[Route('/mentions-legales', name: 'legal_mentions')]
    public function legalMentions(): Response
    {
        return $this->render('general_conditions/legalmentions.html.twig');
    }

     #[Route('/conditions-generales-de-vente', name: 'general_sales_conditions')]
    public function generalSalesConditions(): Response
    {
        return $this->render('general_conditions/gsc.html.twig');
    }
}
