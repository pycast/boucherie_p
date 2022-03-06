<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return[
            TextField::new('name'),
            SlugField::new('slug')->setTargetFieldName('name'),
            TextField::new('subtitle'),
            ImageField::new('illustration')
                ->setBasePath('uploads/')
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextareaField::new('description'),
            MoneyField::new('price')->setCurrency('EUR'),
            ChoiceField::new('unit')->setChoices([
                '100g' => '100g',
                'pièce' => 'pièce',
                'kilo' => 'kilo',
                'dizaine' => 'dizaine',
                'douzaine' => 'douzaine',
            ]
            ),
            AssociationField::new('category'),
            BooleanField::new('visible'),
            BooleanField::new('order_online_open')

        ];
        
    }
    
}
