<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig');
    }

    #[Route('/application', name: '_application')]
    public function application(): Response
    {
        return $this->render('service/application.html.twig');
    }

    #[Route('/consulting', name: '_consulting')]
    public function consulting(): Response
    {
        return $this->render('service/consulting.html.twig');
    }

    #[Route('/iot', name: '_iot')]
    public function iot(): Response
    {
        return $this->render('service/iot.html.twig');
    }
}
