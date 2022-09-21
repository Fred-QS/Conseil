<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferenceController extends AbstractController
{
    #[Route(
        path: '/{_locale}/references',
        name: 'reference',
        requirements: [
            '_locale' => 'en|fr',
        ],
    )]
    public function index(): Response
    {
        return $this->render('reference/index.html.twig');
    }
}
