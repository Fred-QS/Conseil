<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    #[Route(
        path: '/{_locale}/services',
        name: 'service',
        requirements: [
            '_locale' => 'en|fr',
        ],
    )]
    public function index(): Response
    {
        return $this->render('service/index.html.twig');
    }
}
