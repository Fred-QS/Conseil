<?php

namespace App\Controller;

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
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('reference/index.html.twig');
    }

    #[Route('/web', name: '_web')]
    public function web(): Response
    {
        return $this->render('reference/web.html.twig');
    }

    #[Route('/mobile', name: '_mobile')]
    public function mobile(): Response
    {
        return $this->render('reference/mobile.html.twig');
    }

    #[Route('/desktop', name: '_desktop')]
    public function desktop(): Response
    {
        return $this->render('reference/desktop.html.twig');
    }

    #[Route('/training', name: '_training')]
    public function training(): Response
    {
        return $this->render('reference/training.html.twig');
    }
}
