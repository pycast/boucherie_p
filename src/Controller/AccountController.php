<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    private $entityManager;
    

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/compte', name: 'account')]
    public function index(): Response
    {
        $notification = "";
        return $this->render('account/index.html.twig', [
            'notification' => $notification
        ]);
    }

    #[Route('/compte/modifier-mes-informations/{id}', name: 'account_update')]
    public function update(Request $request, $id): Response
    {
        $notification = "";
        $user = $this->entityManager->getRepository(User::class)->findOneById($id);
        
        if (!$user || $user != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $notification = "Votre changements ont été accépté.";
            return $this->redirectToRoute('account');
        }

        return $this->render('account/update.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
