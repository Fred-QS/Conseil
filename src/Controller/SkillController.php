<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/{_locale}/skills',
    name: 'skill',
    requirements: [
        '_locale' => 'en|fr',
    ],
)]
class SkillController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        return $this->render('skill/index.html.twig');
    }

    #[Route('/development', name: '_development')]
    public function development(): Response
    {
        return $this->render('skill/development.html.twig');
    }

    #[Route('/iot', name: '_iot')]
    public function iot(): Response
    {
        return $this->render('skill/iot.html.twig');
    }

    #[Route('/consulting', name: '_consulting')]
    public function consulting(): Response
    {
        return $this->render('skill/consulting.html.twig');
    }
}
