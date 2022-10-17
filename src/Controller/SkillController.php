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
    path: '/{_locale}/skills',
    name: 'skill',
    requirements: [
        '_locale' => 'en|fr',
    ],
)]
class SkillController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}

    /**
     * @throws ErrorException
     */
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('skill');
        return $this->render('skill/index.html.twig', [
            'description' => 'page.skill.description',
            'keywords' => 'page.skill.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/development', name: '_development')]
    public function development(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('development');
        return $this->render('skill/development.html.twig', [
            'description' => 'page.development.description',
            'keywords' => 'page.development.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/iot', name: '_iot')]
    public function iot(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('skill_iot');
        return $this->render('skill/iot.html.twig', [
            'description' => 'page.skill_iot.description',
            'keywords' => 'page.skill_iot.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/consulting', name: '_consulting')]
    public function consulting(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('skill_consulting');
        return $this->render('skill/consulting.html.twig', [
            'description' => 'page.skill_consulting.description',
            'keywords' => 'page.skill_consulting.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page
        ]);
    }
}
