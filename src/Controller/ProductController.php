<?php

namespace App\Controller;

use App\Classes\Search;
use App\Entity\Category;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index( Request $request): Response
    {
        $products= $this->entityManager->getRepository(Product::class)->findAll();
       
       /*filtre*/
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $products=$this->entityManager->getRepository(Product::class)->findWithSearch($search);
            
            
        }

        dd($products);

        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form' => $form->createView()
        ]);
    }

    /**
     * Return butchery products
     */
    #[Route('/nos-produits/boucherie', name: 'products_butchery')]
    public function butcheryProducts( Request $request ): Response
    {

        $categoryButchery= $this->entityManager->getRepository(Category::class)->findByType('1');
    
        $ids=[];
        $products=[];
        
        foreach($categoryButchery as $kategory){
            $ids[]=$kategory->getId();  
            
        }

        foreach ($ids as $id){
            $products[]=$this->entityManager->getRepository(Product::class)->findByCategory($id);
            /*$product correspond à un tableau comprenant les objets dont l'id = $id*/  
           
        }

        foreach($products as $product){
            dd($product);

        }

        
      
        
        
        
        

        

       
       

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $products=$this->entityManager->getRepository(Product::class)->findWithSearch($search);
            
            
        }

        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form' => $form->createView()
        ]);
    }
}
