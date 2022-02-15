<?php

namespace App\Controller;

use App\Classes\Cart;
use App\Entity\Order;
use App\Entity\OrderDetails;
use App\Form\DeliveryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande', name: 'order')]
    public function index(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(DeliveryType::class);
        
        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull()
        ]);
    }
    
    #[Route('/commande/recapitulatif', name: 'order_recap', methods:("POST"))]
    public function add(Cart $cart, Request $request): Response
    {
        $form = $this->createForm(DeliveryType::class);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()){
            $delivery_date = $form->get('delivery_date')->getData();
            // Enregister ma commande Order()
            $date = new \DateTime();
            $order = new Order;

            // $reference = $date->format('dmY').'-'.uniqid();
            // $order->setReference($reference);
            $order->setUser($this->getUser());
            $order->setCreatedAt($date);
            $order->setPayment(0);
            $order->setState(0);
            $order->setDeliveryDate($delivery_date);
            $this->entityManager->persist($order);

        // Enregistrer mes produits OrderDetails()
        foreach ($cart->getFull() as $product) {
            $orderDetails = new OrderDetails();
            $orderDetails->setMyorder($order);
            $orderDetails->setProduct($product['product']->getName());
            $orderDetails->setQuantity($product['quantity']);
            $orderDetails->setPrice($product['product']->getPrice());
            $orderDetails->setTotal($product['product']->getPrice() * $product['quantity']);
            $this->entityManager->persist($orderDetails);
        }

        $this->entityManager->flush();


            {{ dump($orderDetails); }}
        }

        return $this->render('order/add.html.twig', [
            'form' => $form->createView(),
            'cart' => $cart->getFull(),
            // 'reference' => $reference
        ]);
    }
}
