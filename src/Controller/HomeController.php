<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\PageBuilder;

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
    public function index(EntityManagerInterface $entityManager): Response
    {
        $page = (new PageBuilder($entityManager))->buildPage('home');
        return $this->render('home/index.html.twig', [
            'description' => 'page.home.description',
            'keywords' => 'page.home.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }
}
