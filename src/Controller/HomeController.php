<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route(path: '/', name: 'index')]
    #[Route(
        path: '/{_locale}',
        name: 'home',
        requirements: [
            '_locale' => 'en|fr',
        ],
    )]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }
}
