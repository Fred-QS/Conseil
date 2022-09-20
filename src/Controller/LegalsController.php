<?php

namespace App\Controller;

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
    #[Route('/gdpr', name: 'gdpr')]
    public function gdpr(): Response
    {
        return $this->render('info/gdpr.html.twig');
    }

    #[Route('/terms-of-use', name: 'terms')]
    public function terms(): Response
    {
        return $this->render('info/terms.html.twig');
    }

    #[Route('/sitemap', name: 'plan')]
    public function plan(): Response
    {
        return $this->render('info/plan.html.twig');
    }
}
