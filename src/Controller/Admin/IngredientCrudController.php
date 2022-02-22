<?php

namespace App\Controller\Admin;

use App\Entity\Ingredient;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class IngredientCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Ingredient::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return[
            TextField ::new('name'),
            ChoiceField::new('measure')
            ->setChoices([
                'g' => 'g',
                'k' => 'k',
                'L' => 'L',
                'mL' => 'mL',
                'cL' => 'cL',
                'c.à.s' => 'c.à.s',
                'c.à.c' => 'c.à.c',
                'pincée' => 'pincée(s)',
            ]
            )

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
