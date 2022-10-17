<?php

namespace App\Builder;

use App\Builder\SectionBuilder;
use App\Entity\Block;
use Doctrine\ORM\EntityManagerInterface;
use ErrorException;

class PageBuilder
{
    private array $sections;
    private array $blocks;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    /**
     * @throws ErrorException
     */
    public function buildPage(string $page): array
    {
        $blocks = $this->entityManager->getRepository(Block::class)->getPageBlocks($page);
        $sections = $this->orderBySections($blocks);
        $render = [];

        foreach ($sections as $index => $s) {
            $section = new SectionBuilder();
            $section->setSection($s[0]['data']['section']);
            $section->setId($page . '-page-section-' . ($index + 1));
            $section->setClass([$page . '-page-section']);
            $data = [];
            foreach ($s as $item) {
                $data[] = [
                    'fr' => $item['data']['content']['fr'],
                    'en' => $item['data']['content']['en'],
                    'module' => $item['data']['module'],
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
            $index = $block->getSectionOrder() - 1;
            if (!isset($sections[$index])) {
                $sections[$index] = [];
            }
            $sections[$index][] = [
                'order' => $block->getBlockOrder(),
                'data' => [
                    'section' => $block->getSection(),
                    'content' => [
                        'fr' => $block->getContentFr(),
                        'en' => $block->getContentEn()
                    ],
                    'module' => $block->getModule()
                ]
            ];
        }
        return $this->orderByBlocks($sections);
    }

    private function orderByBlocks(array $sections): array
    {
        foreach ($sections as $index => $block) {

            $blocks = [];
            foreach ($block as $key => $row) {
                $blocks[$key] = $row['order'];
            }
            array_multisort($blocks, SORT_ASC, $block);
            $sections[$index] = $block;
        }
        return $sections;
    }
}