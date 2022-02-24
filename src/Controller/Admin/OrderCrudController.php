<?php

namespace App\Controller\Admin;

use App\Classe\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class OrderCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public static function getEntityFqcn(): string
    {
        return Order::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updatePreparation = Action::new('updatePreparation', 'Préparation en cours', 'fas fa-box-open')->linkToCrudAction('updatePreparation');
        $updateDelivery = Action::new('updateDelivery', 'Livraison en cours', 'fas fa-truck')->linkToCrudAction('updateDelivery'); 

        return $actions
        ->add('detail', $updatePreparation)
        ->add('detail', $updateDelivery)
        ->add('index', 'detail');
    }
    public function updatePreparation(AdminContext $context) {
        $order = $context->getEntity()->getInstance();
        $order->setState(2);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span class='alert alert-success'><stong>La commande " . $order->getReference() . " est bien <u>en cours de préparation</u>.</stong></span>");

        $routeBuilder = $this->get(AdminUrlGenerator::class);

    //    $mail = new Mail();
    //    $mail->send(...)

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->setAction('index')->generateUrl());
    }

    public function updateDelivery(AdminContext $context) {
        $order = $context->getEntity()->getInstance();
        $order->setState(3);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span class='alert alert-warning'><stong>La commande " . $order->getReference() . " est bien <u>en cours de Livraison</u>.</stong></span>");

        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(OrderCrudController::class)->setAction('index')->generateUrl());
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC']);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateTimeField::new('createdAt', 'Passée le'),
            TextField::new('user.lastname', 'Utilisateur'),
            MoneyField::new('total', 'Total produit')->setCurrency('EUR'),
            ChoiceField::new('state', 'état de la commande')->setChoices([
                'Non Payée' => 0,
                'Payée' => 1,
                'Préparation en cours' => 2,
                'livraison en cours' => 3
            ]) ,
            ArrayField::new('orderDetails', 'Détails de la commande')->hideOnIndex()
        ];
    }
}  