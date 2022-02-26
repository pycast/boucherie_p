<?php

namespace App\Controller;

use App\Classes\Mail;
use App\Form\ContactType;
use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/nous-contacter', name: 'contact')]
    public function index(Request $request): Response
    {

        $msg = new Contact();
        $form = $this->createForm(ContactType::class, $msg);
        $form->handleRequest($request);

        $alert = '';

        $mail = new Mail();

        // submit = ecriture dans la bdd et envoi d'un mail

        if ($form->isSubmitted() && $form->isValid()) {
            $contactName = $form['firstname']->getData();
            $contactLastname = $form['lastname']->getData();
            $contactMail = $form['email']->getData();
            $contactMessage = $form['message']->getData();

            $content = $contactName . "<br>" . $contactLastname . "<br>" . $contactMail . "<br>" . $contactMessage;

            $mail->send('py.castelleta.pro@gmail.com', 'Boucherie Paux', "Un nouveau message de contact via votre site d'e-Commerce", $content);


            $alert = "Votre message a bien été envoyé " . $contactName . ", nous allons vous répondre dans les meilleurs délais.";

            $msg = $form->getData();

            $this->entityManager->persist($msg);
            $this->entityManager->flush();
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'alert' => $alert
        ]);
    }
}
