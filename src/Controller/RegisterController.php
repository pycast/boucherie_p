<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/inscription', name: 'register')]
    public function index(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $notification = "";
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $mail = new Mail();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user=$form->getData();

            $search_email = $this->entityManager->getRepository(User::class)->findOneByEmail($user->getEmail());
        
            if (!$search_email) {
                $password = $passwordHasher->hashPassword(
                    $user,
                    $user->getPassword()
                );
                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Votre inscription s'est correctement déroulé. Vous pouvez dès à présent vous connecter à votre compte, vous venez de recevoir un e-mail sur votre boîte mail que vous venez de renseigner.";

                $mail->send($user->getEmail(), $user->getFirstname(), "Inscription réussie sur le site de votre artisan", "Bienvenue sur le site de votre artisan Benoît Paux. Votre inscription a été enregistrée vous pouvez maintenant faire vos achats et suivre vos commandes.");

            } else {
                $notification = "L'email que vous avez renseigné existe déjà.";
            }
        }


        return $this->render('register/index.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification
        ]);
    }
}
