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
    path: '/{_locale}/services',
    name: 'service',
    requirements: [
        '_locale' => 'en|fr',
    ],
)]
class ServiceController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}

    /**
     * @throws ErrorException
     */
    #[Route('/', name: '_index')]
    public function index(Request $request): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('service', $request->getLocale());
        return $this->render('service/index.html.twig', [
            'description' => 'page.service.description',
            'keywords' => 'page.service.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/application', name: '_application')]
    public function application(Request $request): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('application', $request->getLocale());
        return $this->render('service/application.html.twig', [
            'description' => 'page.application.description',
            'keywords' => 'page.application.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/consulting', name: '_consulting')]
    public function consulting(Request $request): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('services_consulting', $request->getLocale());
        return $this->render('service/consulting.html.twig', [
            'description' => 'page.services_consulting.description',
            'keywords' => 'page.services_consulting.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/iot', name: '_iot')]
    public function iot(Request $request): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('services_iot', $request->getLocale());
        return $this->render('service/iot.html.twig', [
            'description' => 'page.services_iot.description',
            'keywords' => 'page.services_iot.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }
}
