<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Entity\OrderDetails;
use App\Entity\Quantity;
use App\Entity\Recipe;
use Doctrine\ORM\EntityManagerInterface;
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
                    'recette'=>$recipe->getProduct()
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
                $arrayIdIngredient=[];
                foreach ($repositoryIngredient as $ingredientID){
                    $arrayIdIngredient[]=$ingredientID->getId();
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
            'arrayIdIngredient'=>$arrayIdIngredient
            

        ]);

    }

}