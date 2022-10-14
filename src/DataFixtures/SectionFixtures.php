<?php

namespace App\DataFixtures;

use App\Entity\Section;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SectionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $sections = [
            [
                'title' => 'Full',
                'structure' => '1/1',
                'settings' => [
                    'background-color' => 'inherit',
                    'color' => 'inherit'
                ]
            ],
            [
                'title' => 'Half split',
                'structure' => '1/2',
                'settings' => [
                    'background-color' => 'inherit',
                    'color' => 'inherit'
                ]
            ],
            [
                'title' => '1/3 and 2/3',
                'structure' => '1/3',
                'settings' => [
                    'background-color' => 'inherit',
                    'color' => 'inherit'
                ]
            ],
            [
                'title' => '2/3 and 1/3',
                'structure' => '2/3',
                'settings' => [
                    'background-color' => 'inherit',
                    'color' => 'inherit'
                ]
            ]
        ];
        foreach ($sections as $s) {
            $section = new Section();
            $section->setSettings($s['settings']);
            $section->setStructure($s['structure']);
            $section->setTitle($s['title']);
            $manager->persist($section);
            $manager->flush();
        }

    }
}
