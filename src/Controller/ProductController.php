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

        $title='';

        $products= $this->entityManager->getRepository(Product::class)->findAll();
       
       /*filtre*/
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $products=$this->entityManager->getRepository(Product::class)->findWithSearch($search);
            
            
        }

        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form' => $form->createView(),
            'title'=> $title
        ]);
    }

    /**
     * Return butchery products
     */
    #[Route('/nos-produits/boucherie', name: 'products_butchery')]
    public function butcheryProducts( Request $request ): Response
    {
        $title='boucherie';

        $categoryButchery= $this->entityManager->getRepository(Category::class)->findByType('1');
    
        $ids=[];
        
        foreach($categoryButchery as $kategory){
            $ids[]=$kategory->getId();  
            
        }

        $products=$this->entityManager->getRepository(Product::class)->findByCategory($ids);



        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $products=$this->entityManager->getRepository(Product::class)->findWithSearchButchery($search);
            
            
        }

        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form' => $form->createView(),
            'title'=> $title
        ]);
    }


    /**
     * Return caterer products
     */
    #[Route('/nos-produits/traiteur', name: 'products_caterer')]
    public function catererProducts( Request $request ): Response
    {
        $title='traiteur';

        $categoryCaterer= $this->entityManager->getRepository(Category::class)->findByType('0');
    
        $ids=[];
        
        foreach($categoryCaterer as $kategory){
            $ids[]=$kategory->getId();  
            
        }

        $products=$this->entityManager->getRepository(Product::class)->findByCategory($ids);

    

        $search = new Search();
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $products=$this->entityManager->getRepository(Product::class)->findWithSearchCaterer($search);
            
            
        }

        return $this->render('product/index.html.twig', [
            'products'=>$products,
            'form' => $form->createView(),
            'title'=> $title
        ]);
    }
}
