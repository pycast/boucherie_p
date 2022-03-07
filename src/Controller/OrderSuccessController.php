<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Classes\Mail;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/commande/merci/{stripeSessionId}", name: "order_success")]
    public function index(Cart $cart, $stripeSessionId): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripesessionid($stripeSessionId);

        $mail = new Mail();

        if (!$order  || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('home');
        }

        if ($order->getState() == 0) {
            // Vider la session "cart"
            $cart->remove();
            // Modifier le statut is paid de la commande en mettant 1
            $order->setPayment(1);
            $order->setState(1);
            $this->entityManager->persist($order);
            $this->entityManager->flush();

            $content = "Votre paiement a été accepté. Vous pouvez maintenant suivre votre commande dans votre espace client sur le site de votre artisan.";
            // Envoyer un email à notre client pour lui confirmer sa commande 
            $mail->send($order->getUser()->getEmail(), 'Client', 'Paiement accepté, commande validée', $content);

        }
        return $this->render('order_success/index.html.twig', [
            'order' => $order
        ]);
    }
}