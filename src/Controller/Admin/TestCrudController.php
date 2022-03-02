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
                    'qt'=>null
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
        dd($listeProduitsRéférencés); 
        
        

        
        








         for ($i=0; $i< (count($arrayProduitsQuantities)); $i++){
        $listeProduits[]=$arrayProduitsQuantities[$i]['produit'];
       }
      
      $listeDef[]=$listeProduits[0];
       for ($b=1; $b < (count($listeProduits)); $b++){
         
            foreach($listeDef as $produi){
                
                        if($produi == $listeProduits[$b]){
                            $listeDef[]='dejà pris';
                        }else{
                            $listeDef[]=$listeProduits[$b];
                        }
                    }
                }

                
            
           dd($listeDef);  
       
      

       $nlleListe=$listeDef->findByName('Dinde blanche');
       dd($listeDef);


       
       















        //----get recipe ID + Name of product-------
         $repositoryRecipe= $this->entityManager->getRepository(Recipe::class)->findAll();
         
         foreach ($repositoryRecipe as $recipeQuantity){
           
         }

         $idRecipe=[];//ensemble des ID recettes
         $nameRecipe=[];//ensemble des noms de recettes (=nom du produit)
         foreach ($repositoryRecipe as $recipe){
                $products=$recipe->getProduct();
                 $nameRecipe[]=$products->getName();
                $idRecipe[]=[
                    'id'=>$recipe->getId(),
                    'recette'=>$recipe->getProduct(),
                ];  
                
               
            }
         
         //------get all quantity table-----------
          $repositoryQuantities= $this->entityManager->getRepository(Quantity::class)->findAll();
          
        
          //--------get Quantity of each product ordered---------
          
         
             $arrayPrdQut=[];//tableau qui comprends un tableau par recette commandée

          foreach($nameRecipe as $produitCommandé){
                //dans le repositoryOrderDetails, je cherche un produit qui corresponde à un nom de recette.
                //si je trouve c'est que le produit a été commandé au moins une fois ou plus.
                $repositoryOrderDetails= $this->entityManager->getRepository(OrderDetails::class)->findByProduct($produitCommandé);
                //si produit trouvé/commandé:
                if ($repositoryOrderDetails){
                    
                    $qt=0;//regroupe ensemble des quantités d'un produit donné.
                    //à chaque fois que le produit est trouvé, getQuantity +1
                    foreach($repositoryOrderDetails as $detail){
                        $qt+=$detail->getQuantity();  
                    }
                    //on regroupe le tout dans un tableau, un nom de produit, le nombre de fois où il a été commandé
                    $arrayPrdQut[]=[
                        'produit'=>$produitCommandé,
                        'qté'=>$qt
                    ];  
                }
                

            //-----get ingredient repository---
            $repositoryIngredient= $this->entityManager->getRepository(Ingredient::class)->findAll();
                //créer un tableau avec les id des aliments existants
                $arrayNameIngredient=[];
                foreach ($repositoryIngredient as $ingredientName){
                    $arrayNameIngredient[]=$ingredientName->getName();
                }
                

          }
        
        
        return $this->render('admin/index.html.twig',[
           
           
            'repositoryRecipe'=>$repositoryRecipe,
            'repositoryQuantities'=>$repositoryQuantities,
            'idRecipe'=>$idRecipe,//produit(objet) + id de la recette
            'repositoryOrderDetails'=>$repositoryOrderDetails,
            'nameRecipe'=>$nameRecipe,//le nom des recettes existantes( correspondent au même nom de produit)
            'produitCommandé'=>$produitCommandé,//Dans les produits existants, nom des produits commandés (attention pas de tableau ici)
            'arrayPrdQut'=>$arrayPrdQut,//Array: nom du produit, le nombre de fois où il a été commandé(sur total des commandes).
            
            'arrayNameIngredient'=>$arrayNameIngredient,
            'arrayIdOrderValid'=>$arrayIdOrderValid
            

        ]);

    }

}