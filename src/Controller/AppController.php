<?php

namespace App\Controller;

use App\Repository\BookRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app")
     */
    public function index(BookRepository $bookRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'ACCUEIL',
            'books' => $bookRepository->findAll(),
        ]);
    }
}
