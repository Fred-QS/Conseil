<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route(
    path: '/{_locale}/it-news',
    name: 'blog',
    requirements: [
        '_locale' => 'en|fr',
    ],
)]
class ArticleController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}
    
    #[Route('/', name: '_index')]
    public function index(Request $request): Response
    {
        $locale = $request->getLocale();
        $page = 1;
        $category = null;
        $orderBy = 'DESC';

        if ($request->get('page') !== null) {
            $page = (int) $request->get('page');
        }

        if ($request->get('category') !== null) {
            $category = $request->get('category');
        }

        if ($request->get('order') !== null) {
            $orderBy = $request->get('order');
        }

        $articles = $this->entityManager->getRepository(Article::class)->findAllByOrderDesc($locale, $page, $category, $orderBy);
        $totalArticles = count($articles);

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'totalItems' => $totalArticles,
            'pages' => ceil(($totalArticles/10))
        ]);
    }

    #[Route('/article/{uri}', name: '_article')]
    public function article(Request $request, string $uri): Response
    {
        $lang = ($request->getLocale() === 'fr') ? 'french' : 'english';
        $article = $this->entityManager->getRepository(Article::class)->findOneBy(['uri' => $uri, 'language' => $lang]);
        return $this->render('article/article.html.twig', [
            'article' => $article
        ]);
    }
}
