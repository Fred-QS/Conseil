<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Block;

class BlockFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $blocks = [
            [
                'section' => 2,
                'sectionOrder' => 1,
                'blockOrder' => 2,
                'page' => 'home',
                'contentFr' => '<p>Test de bloc</p>',
                'contentEn' => '<p>Bloc test</p>',
                'module' => 'text'
            ],
            [
                'section' => 2,
                'sectionOrder' => 1,
                'blockOrder' => 1,
                'page' => 'home',
                'contentFr' => 'images/page/home.jpg',
                'contentEn' => 'images/page/home.jpg',
                'module' => 'image'
            ],
        ];

        foreach ($blocks as $b) {

            $block = new Block();
            $block->setSection($b['section']);
            $block->setSectionOrder($b['sectionOrder']);
            $block->setBlockOrder($b['blockOrder']);
            $block->setPage($b['page']);
            $block->setContentFr($b['contentFr']);
            $block->setContentEn($b['contentEn']);
            $block->setModule($b['module']);
            $manager->persist($block);
            $manager->flush();
        }

    }
}
