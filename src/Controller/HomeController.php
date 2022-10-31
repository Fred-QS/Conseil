<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Builder\PageBuilder;

class HomeController extends AbstractController
{
    /**
     * @throws ErrorException
     */
    #[Route(path: '/', name: 'index')]
    #[Route(
        path: '/{_locale}',
        name: 'home',
        requirements: [
            '_locale' => 'en|fr',
        ],
    )]
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
        $page = (new PageBuilder($entityManager))->buildPage('home', $request->getLocale());
        return $this->render('home/index.html.twig', [
            'description' => 'page.home.description',
            'keywords' => 'page.home.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }
}
