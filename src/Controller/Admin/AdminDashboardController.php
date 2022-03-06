<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Histoire;
use App\Entity\Ingredient;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Quantity;
use App\Entity\Recipe;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminDashboardController extends AbstractDashboardController
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController( CategoryCrudController::class)->generateUrl());

         //return $this->redirect($adminUrlGenerator->setController( ProductCrudController ::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        //return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Boucherie Paux');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Accueil', 'fas fa-home', $this->generateUrl('home') );
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-tag', Category ::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-store', Product ::class);
        yield MenuItem::linkToCrud('1.Recettes', 'fas fa-book', Recipe ::class);
        yield MenuItem::linkToCrud('2.Ingrédients', 'fas fa-smile', Ingredient ::class);
        yield MenuItem::linkToCrud('3.Quantités', 'fas fa-weight', Quantity::class);
        
        yield MenuItem::linkToCrud('Commandes', 'fas fa-box', Order ::class);
        yield MenuItem::linkToCrud('Histoire', 'fas fa-newspaper', Histoire ::class);
        yield MenuItem::linkToRoute('Liste prévisionnelle', 'fas fa-list', 'shopping_ingredient_list');
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
        ->addWebpackEncoreEntry('admin');
    }
}
