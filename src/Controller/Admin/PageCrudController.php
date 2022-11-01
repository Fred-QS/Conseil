<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use App\Repository\BlockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class PageCrudController extends AbstractController
{
    private array $pages;
    private array $excepts = [
        'index',
        'blog_index',
        'blog_article',
        'contact',
        'info_gdpr',
        'info_plan',
        'info_terms'
    ];

    public function __construct(private BlockRepository $blockRepository)
    {
        $path = dirname(__DIR__, 3).'/data/backgrounds.yaml';
        $pages = Yaml::parseFile($path, Yaml::PARSE_CONSTANT);

        foreach ($pages as $title => $bg) {
            if (!in_array($title, $this->excepts, true)) {
                $this->pages[] = [
                    'title' => $title,
                    'background' => $bg,
                    'sections' => $this->blockRepository->findBy(['page' => $title])
                ];
            }
        }
    }

    #[Route('/admin/page', name: 'admin_page')]
    public function index(): Response
    {
        return $this->render('admin/page/index.html.twig', [
            'pages' => $this->pages
        ]);
    }

    #[Route('/admin/page/{page}', name: 'admin_page_show')]
    public function show(string $page): Response
    {
        $selected = $this->getPage($page);
        if ($selected === null) {
            throw $this->createNotFoundException('This page does not exists.');
        }

        dump($selected);
        return $this->render('admin/page/show.html.twig');
    }

    private function getPage(string $page): ?array
    {
        foreach ($this->pages as $p) {
            if ($p['title'] === $page) {
                return $p;
            }
        }
        return null;
    }
}
