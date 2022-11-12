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
                'blockOrder' => 1,
                'page' => 'home',
                'contentFr' => '{"link":"","src":"images/page/home.jpg","alt":""}',
                'contentEn' => '{"link":"","src":"images/page/home.jpg","alt":""}',
                'module' => 'image'
            ],
            [
                'section' => 2,
                'sectionOrder' => 1,
                'blockOrder' => 2,
                'page' => 'home',
                'contentFr' => '{"background":"","title":"<h3>Test</h3>","text":"<p>Test de bloc</p>","buttons":[{"href":"home","name":"test"}]}',
                'contentEn' => '{"background":"","title":"<h3>Test</h3>","text":"<p>Bloc test</p>","buttons":[{"href":"home","name":"test"}]}',
                'module' => 'text'
            ],
            [
                'section' => 3,
                'sectionOrder' => 2,
                'blockOrder' => 1,
                'page' => 'home',
                'contentFr' => '{"link":"blog_index","src":"images/page/home.jpg","alt":""}',
                'contentEn' => '{"link":"blog_index","src":"images/page/home.jpg","alt":""}',
                'module' => 'image'
            ],
            [
                'section' => 3,
                'sectionOrder' => 2,
                'blockOrder' => 2,
                'page' => 'home',
                'contentFr' => '{"background":"","title":"<h3>Ouai</h3>","text":"<p>Test de bloc</p>","buttons":[{"href":"home","name":"test"}]}',
                'contentEn' => '{"background":"","title":"<h3>Yeah</h3>","text":"<p>Bloc test</p>","buttons":[{"href":"home","name":"test"}]}',
                'module' => 'text'
            ],
            [
                'section' => 6,
                'sectionOrder' => 3,
                'blockOrder' => 1,
                'page' => 'home',
                'contentFr' => '{"background":"images/page/home.jpg","title":"<h1>Full</h1>","text":"<p>Test de bloc full</p>","buttons":[]}',
                'contentEn' => '{"background":"images/page/home.jpg","title":"<h1>Full</h1>","text":"<p>Full bloc test</p>","buttons":[]}',
                'module' => 'text'
            ],
            [
                'section' => 4,
                'sectionOrder' => 4,
                'blockOrder' => 1,
                'page' => 'home',
                'contentFr' => '{"background":"","title":"<h2>Yes</h2>","text":"<p>Test de bloc 2</p>","buttons":[]}',
                'contentEn' => '{"background":"","title":"<h2>Yes</h2>","text":"<p>Bloc 2 test</p>","buttons":[]}',
                'module' => 'text'
            ],
            [
                'section' => 4,
                'sectionOrder' => 4,
                'blockOrder' => 2,
                'page' => 'home',
                'contentFr' => '{"background":"","title":"<h2>Yes</h2>","text":"<p>Test de bloc 2</p>","buttons":[]}',
                'contentEn' => '{"background":"","title":"<h2>Yes</h2>","text":"<p>Bloc 2 test</p>","buttons":[]}',
                'module' => 'text'
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
