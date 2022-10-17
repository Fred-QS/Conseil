<?php

namespace App\Builder;

use App\Builder\SectionBuilder;
use App\Entity\Block;
use Doctrine\ORM\EntityManagerInterface;

class PageBuilder
{
    private array $sections;
    private array $blocks;

    public function __construct(
        private EntityManagerInterface $entityManager
    ) {}

    public function buildPage(string $page): ?string
    {
        $blocks = $this->entityManager->getRepository(Block::class)->getPageBlocks($page);
        if (!empty($blocks)) {
            $section = new SectionBuilder();
            return '';
        }

        return null;
    }
}