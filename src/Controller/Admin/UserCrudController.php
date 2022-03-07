<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $updateRoles = Action::new('updateRoles', 'definir en tant que Admin', 'fas fa-admin')->linkToCrudAction('updateRoles');

        return $actions
        ->add('detail', $updateRoles)
        ->add('index', 'detail');
    } 

    public function updateRoles(AdminContext $context) {
        $user = $context->getEntity(User::class)->getInstance();
        $user->setRoles(['ROLE_ADMIN']);
        $this->entityManager->flush();

        $this->addFlash('notice', "<span class='alert alert-warning'><stong>L'utilisateur' " . $user->getlastname() . " est devenu <u>Admin</u>.</stong></span>");

        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(UserCrudController::class)->setAction('index')->generateUrl());
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->setDefaultSort(['id' => 'DESC'])
        ->setEntityLabelInPlural('Utilisateurs')
        ->setEntityLabelInSingular('Utilisateurs');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('firstname', 'Nom'),
            TextField::new('lastname', 'Prénom'),
            TelephoneField::new('phone', 'Téléphone'),
            EmailField::new('email', 'Email'),
            BooleanField ::new('roles', 'Rôles'),
        ];
    }
    
}
