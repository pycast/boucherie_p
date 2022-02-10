<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/test', name: 'test')]
    public function index(): Response
    {
        $products= $this->entityManager->getRepository(Product::class)->findAll();
        
        return $this->render('test/index.html.twig', [
            'products'=>$products

        ]);
    }
}
