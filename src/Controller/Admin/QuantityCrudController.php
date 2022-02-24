<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use App\Entity\Quantity;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class QuantityCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Quantity::class;
        
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            FormField::addTab('1. Choix du plat :'),
            AssociationField::new('recipe'),
            FormField::addTab('2. La liste des ingrédients :'),
            FormField::addPanel('Ajouter un ingrédient :')->collapsible(),
            AssociationField::new('ingredient'),
            FormField::addPanel('Quantité :')->collapsible(),
            NumberField::new('quantity')
            
            
            
            
            

        ];
        
        
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
