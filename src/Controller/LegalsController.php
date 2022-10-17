<?php

namespace App\Controller;

use App\Builder\PageBuilder;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route(
    path: '/{_locale}/info',
    name: 'info_',
    requirements: [
        '_locale' => 'en|fr',
    ],
)]
class LegalsController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager){}

    /**
     * @throws ErrorException
     */
    #[Route('/gdpr', name: 'gdpr')]
    public function gdpr(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('info_gdpr');
        return $this->render('info/gdpr.html.twig', [
            'description' => 'page.info_gdpr.description',
            'keywords' => 'page.info_gdpr.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page

        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/terms-of-use', name: 'terms')]
    public function terms(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('info_terms');
        return $this->render('info/terms.html.twig', [
            'description' => 'page.info_terms.description',
            'keywords' => 'page.info_terms.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page

        ]);
    }

    /**
     * @throws ErrorException
     */
    #[Route('/sitemap', name: 'plan')]
    public function plan(): Response
    {
        $page = (new PageBuilder($this->entityManager))->buildPage('info_plan');
        return $this->render('info/plan.html.twig', [
            'description' => 'page.info_plan.description',
            'keywords' => 'page.info_plan.keywords',
            'image' => '/uploads/pages/test.jpg',
            'page' => $page

        ]);
    }
}
