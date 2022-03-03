<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Entity\Product;
use App\Entity\Quantity;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Stmt\Foreach_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class TestCrudController extends AbstractController

{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

     #[Route('/testCrudController', name: 'test_crud_controller')]
    public function index():Response
    {  

        //1.Récupérer les id des commandes valides
        $repoOrder=$this->entityManager->getRepository(Order::class)->findByPayment(1);
        
        $arrayIdOrderValid=[];
        foreach ($repoOrder as $orderValid){
            $arrayIdOrderValid[]=$orderValid->getId();
            
        }
        
        

        //2. Récupérer le détail des commandes valides

        $arrayDetailValid=[];//stocke des objets orderDetail
        foreach ($arrayIdOrderValid as $orderDetailValid){
            $repoOrderDetails=$this->entityManager->getRepository(OrderDetails::class)->findByMyOrder($orderDetailValid);
            
            $arrayDetailValid[]=$repoOrderDetails;
        }
        
       
       

        //3. Parmi les commandes valides, récupérer la liste des produits avec un quantité associé
        $arrayProduitsQuantities=[];
        foreach ($arrayDetailValid as $ProduitQuantity){
            foreach($ProduitQuantity as $produit){
                 $arrayProduitsQuantities[]= [
                     'produit'=>$produit->getProduct(),
                     'quantité'=>$produit->getQuantity()
                 ];

            }
        }
        
       
        //4.Grâce à la table produits, récupérer les produits référencés
        $listeProduitsRéférencés=[]; //liste de tous les produits référencés dans catalogue.
        $repoProduct=$this->entityManager->getRepository(Product::class)->findAll();
        foreach($repoProduct as $product){
            $listeProduitsRéférencés[]=[
                    'name'=>$product->getName(),
                    'idProduct'=>$product->getId(),
                    'qt'=>0
            ];
        }
      
        
        

        //5.Pour chaque produit réf, chercher tous les produits du même nom dans l' arrayProduitsQuantities, si vrai: modif qt.
        $keyLPR=0;
        foreach($listeProduitsRéférencés as $produitRéférencé){
            
            foreach($arrayProduitsQuantities as $produitCommandé)
            if($produitRéférencé['name'] == $produitCommandé['produit']){
                $newQt=$produitCommandé['quantité'];
                $produitRéférencé['qt']+=$newQt;
               $listeProduitsRéférencés[$keyLPR]['qt']=$produitRéférencé['qt'];  
              
            }  
           $keyLPR++;
        
        }
        //dd($listeProduitsRéférencés);// mtnt égale au nombre de produits référencés commandés.

        //6. Associer une id recette pour chaque produit référencé commandé
        $keyLPR=0;
        foreach($listeProduitsRéférencés as $produitRéférencé){
            $idProduct=$produitRéférencé['idProduct'];
            $repoRecipe=$this->entityManager->getRepository(Recipe::class)->findByProduct($idProduct);
            
            $idRecipe=$repoRecipe[0]->getId();
              // $listeProduitsRéférencés[$keyLPR]['qt']=$produitRéférencé['qt'];  
            $produitRéférencé['idAssociatedRecipe']=$idRecipe;
            $listeProduitsRéférencés[$keyLPR]=$produitRéférencé;  
            
             $keyLPR++;    
        } 
        
        //7.Associer liste d'ingrédient pour chaque produit/recette
            //Pour chaque produit, get id recette, dans ingredientrepo, find ingredient by recipe(nb)
            $keyLPR=0;
            foreach($listeProduitsRéférencés as $produitRéférencé){
                $idRecipe=$produitRéférencé['idAssociatedRecipe'];
                $qtNeeded=$produitRéférencé['qt'];
                
                $repoQuantity=$this->entityManager->getRepository(Quantity::class)->findByRecipe($idRecipe);
                $IngdtsList=[];
                $keyRQ=0;
                foreach($repoQuantity as $qt){
                    $ingredientId=($qt->getIngredient())->getId();
                    $IngdtsList[$keyRQ]=[
                        'idIngredient'=>$ingredientId,
                        'qtIngredient'=>($qt->getQuantity())*($qtNeeded)
                    ];
                    
                    $keyRQ++;    
                }
                
                $produitRéférencé['ingdtsList']=$IngdtsList;
               
                $listeProduitsRéférencés[$keyLPR]['ingdtsList']=$produitRéférencé['ingdtsList'];
                $keyLPR++; 
            }
          

        //8.Dans la $listeProduitsRéférencés obtenue au dessus, récupérer toutes les qt pr un ingredient donné;
           
        $repoIngredient=$this->entityManager->getRepository(Ingredient::class)->findAll(); 
        $newList=[];   
        foreach($repoIngredient as $ingredient){
                $newList[]=[
                    'id'=>$ingredient->getId(),
                    'name'=>$ingredient->getName(),
                    'qtDef'=>0,
                    'measure'=>$ingredient->getMeasure()

                ];
            }
        
            $keyNewList=0;
        foreach($newList as $ingredient){
            $ingredient['qtDef']=0;
            $i=0;
            foreach($listeProduitsRéférencés[$i]['ingdtsList'] as $listProduit){
        
                if($listProduit['idIngredient'] == $ingredient['id']){
                    $ingredient['qtDef']+=$listProduit['qtIngredient'];
                }
               $i++; 
            }
            $newList[$keyNewList]['qtDef']+=$ingredient['qtDef'];
            $keyNewList++;
            
           
        }
        
         //dd($listeProduitsRéférencés);Qt/recette
         //:qt totales
        
       
        
        return $this->render('admin/index2.html.twig',[
           'listeProduitsRéférencés'=>$listeProduitsRéférencés,
            'newList'=>$newList
        ]);

    }

}