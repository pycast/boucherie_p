<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GitPyController extends AbstractController
{
    /**
     * @Route("/git/py", name="git_py")
     */
    public function index(): Response
    {
        return $this->render('git_py/index.html.twig', [
            'controller_name' => 'GitPyController',
        ]);
    }
}
