<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Entity\Quantity;
use App\Entity\Recipe;
use App\Form\IngredientType;
use App\Form\QuantityType;
use App\Form\RecipeType;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;

class TestCrudController extends AbstractController

{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

     #[Route('/testCrudController', name: 'test_crud_controller')]
    public function index(Request $request):Response
    {
        $notificationRecipe=null;
        $notificationIngredient=null;
        $notificationQuantity=null;
        //First recipe form to insert recipe in database
        $recipe = new Recipe();
        $formRecipe = $this->createForm(RecipeType::class, $recipe);
        $formRecipe->handleRequest($request);

            if ($formRecipe->isSubmitted() && $formRecipe->isValid()){
                $recipe=$formRecipe->getData();
                $search_recipe = $this->entityManager->getRepository(Recipe::class)->findOneByProduct($recipe->getProduct());
                
                        if (!$search_recipe) {
                                //if recipe doesn't exist in database:
                                $this->entityManager->persist($recipe);
                                $this->entityManager->flush();
                                $notificationRecipe='Recette ajoutée dans la bdd, maintenant ajoutez des ingrédients';
                    
                            }else{
                                //else if recipe already exists
                                $notificationRecipe='Cette recette existe déjà, vous pouvez la modifier';    
                            }
            }


        //Second ingredient form to create ingrédients
        /**
         * Etape 1:créer une base d'ingrédients
         * Etape 2:Obtenir une liste d'ingrédients
         */
        $ingredient = new Ingredient();
        $formIngredient = $this->createForm(IngredientType::class, $ingredient);
        $formIngredient->handleRequest($request);
        
         if ($formIngredient->isSubmitted() && $formIngredient->isValid())
         {
                $ingredient=$formIngredient->getData();
                //dd($ingredient);
                $this->entityManager->persist($ingredient);
                $this->entityManager->flush();
                $notificationIngredient='ingrédient ajouté avec succès';
            }

        //Third set quantity, link to ingredient, link to recipe 
       
        $quantity = new Quantity();
        $formQuantity = $this->createForm(QuantityType::class, $quantity);
        $formQuantity->handleRequest($request);
        
         if ($formQuantity->isSubmitted() && $formQuantity->isValid())
         {
                $quantity=$formQuantity->getData();
                //dd($ingredient);
                $this->entityManager->persist($quantity);
                $this->entityManager->flush();
                $notificationQuantity='ingrédient ajouté avec succès';
            }



        //get recipe ID + Name of product
         $repositoryRecipe= $this->entityManager->getRepository(Recipe::class)->findAll();

         $idRecipe=[];
         foreach ($repositoryRecipe as $recipe){
            
             $idRecipe[]=[
                 'id'=>$recipe->getId(),'recette'=>$recipe->getProduct()];  
         }
         
         //get all quantity table
          $repositoryQuantities= $this->entityManager->getRepository(Quantity::class)->findAll();
         
          //get order table
         
          
             
         
             
        
        
         //dd($repositoryRecipe);
        //get ingredients
         
         
         
         



        



        

    

        
        return $this->render('admin/index.html.twig',[
            'formRecipe'=>$formRecipe->createView(),
            'formIngredient'=>$formIngredient->createView(), 
            'formQuantity'=>$formQuantity->createView(), 
            'notificationRecipe'=>$notificationRecipe,
            'notificationIngredient'=>$notificationIngredient,
            'notificationQuantity'=>$notificationQuantity,
            'repositoryRecipe'=>$repositoryRecipe,
            'repositoryQuantities'=>$repositoryQuantities,
            'idRecipe'=>$idRecipe

            

        ]);

    }

}