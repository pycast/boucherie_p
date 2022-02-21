<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nos-produits', name: 'products')]
    public function index(): Response
    {
        $products= $this->entityManager->getRepository(Product::class)->findAll();
        
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);
        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form' => $form->createView()
        ]);
    }
}
