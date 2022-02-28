<?php

namespace App\Controller;

use App\Entity\Header;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $headers = $this->entityManager->getRepository(Header::class)->findAll();


        $notification = "";
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'notification' => $notification,
            'headers' => $headers
        ]);
    }
}
