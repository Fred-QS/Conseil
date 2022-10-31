<?php

namespace App\Builder;

use App\Builder\SectionBuilder;
use App\Entity\Block;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;

class PageBuilder
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @throws ErrorException
     */
    public function buildPage(string $page, string $locale): array
    {
        $blocks = $this->entityManager->getRepository(Block::class)->getPageBlocks($page, $locale);
        $sections = $this->orderBySections($blocks);
        $render = [];

        foreach ($sections as $index => $s) {
            $section = new SectionBuilder();
            $section->setSection($s['ref']);
            $section->setId($page . '-page-section-' . ($index + 1));
            $data = [];
            foreach ($s['blocks'] as $item) {
                $data[] = [
                    'content' => $item['data']['content'],
                    'module' => $item['data']['module'],
                    'order' => $item['data']['order'],
                ];
            }
            $section->setData($data);
            $render[] = $section->render();
        }

        return $render;
    }

    private function orderBySections(array $blocks): array
    {
        $sections = [];
        /**@var Block[] $blocks*/
        foreach ($blocks as $block) {
            $index = $block['sectionOrder'] - 1;
            if (!isset($sections[$index])) {
                $sections[$index] = [];
            }
            $sections[$index]['name'] = '';
            $sections[$index]['ref'] = $block['section'];
            $sections[$index]['blocks'][] = [
                'data' => [
                    'module' => $block['module'],
                    'content' => $block['content'],
                    'order' => $block['blockOrder'],
                ]
            ];
        }
        return $sections;
    }
}