<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use App\Repository\BlockRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;
use App\Builder\FormBuilder;

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
    public function index( Request $request): Response
    {
        $mode = $request->get('mode');
        $page = $request->get('page');
        if (method_exists($this, $mode)) {
            return $this->$mode($page, $request);
        }
        return $this->render('admin/page/index.html.twig', [
            'pages' => $this->pages
        ]);
    }

    private function edit(string $page, Request $request): Response
    {
        $selected = $this->getPage($page);
        if ($selected === null) {
            throw $this->createNotFoundException('This page does not exists.');
        }

        $selected['sections'] = $this->blockRepository->findBy(['page' => $page]);

        $formBuilder = new FormBuilder();
        $formated = $formBuilder->setData($selected, $request->getLocale());

        if ($request->isXmlHttpRequest()) {
            return $this->ajax($request, $formated);
        }

        return $this->render('admin/page/edit.html.twig', [
            'page' => $formated
        ]);
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

    private function ajax(Request $request, array $page): Response
    {
        return $this->render('_macros/_forms/block.html.twig', [
            'page' => $page
        ]);
    }
}
