<?php

namespace App\Controller;

use App\Builder\PageBuilder;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/{_locale}/references',
    name: 'reference',
    requirements: [
        '_locale' => 'en|fr',
    ],
)]
class ReferenceController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}

    /**
     * @throws ErrorException
     */
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('reference');
        return $this->render('reference/index.html.twig', [
            'description' => 'page.reference.description',
            'keywords' => 'page.reference.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page

        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/web', name: '_web')]
    public function web(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('web');
        return $this->render('reference/web.html.twig', [
            'description' => 'page.web.description',
            'keywords' => 'page.web.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page

        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/mobile', name: '_mobile')]
    public function mobile(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('mobile');
        return $this->render('reference/mobile.html.twig', [
            'description' => 'page.mobile.description',
            'keywords' => 'page.mobile.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page

        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/desktop', name: '_desktop')]
    public function desktop(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('desktop');
        return $this->render('reference/desktop.html.twig', [
            'description' => 'page.desktop.description',
            'keywords' => 'page.desktop.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/training', name: '_training')]
    public function training(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('training');
        return $this->render('reference/training.html.twig', [
            'description' => 'page.training.description',
            'keywords' => 'page.training.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }
}
