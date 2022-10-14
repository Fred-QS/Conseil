<?php

namespace App\DataFixtures;

use App\Entity\Page;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pages = [
            [
                'published' => 1,
                'keywords' => 'page.home.keywords',
                'description' => 'page.home.description',
                'title' => 'route.home',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.skill.keywords',
                'description' => 'page.skill.description',
                'title' => 'route.skill',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.reference.keywords',
                'description' => 'page.reference.description',
                'title' => 'route.reference',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.service.keywords',
                'description' => 'page.service.description',
                'title' => 'route.service',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.info_terms.keywords',
                'description' => 'page.info_terms.description',
                'title' => 'route.info_terms',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.info_gdpr.keywords',
                'description' => 'page.info_gdpr.description',
                'title' => 'route.info_gdpr',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.info_plan.keywords',
                'description' => 'page.info_plan.description',
                'title' => 'route.info_plan',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.blog.keywords',
                'description' => 'page.blog.description',
                'title' => 'route.blog',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.skill_iot.keywords',
                'description' => 'page.skill_iot.description',
                'title' => 'route.iot',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.skill_consulting.keywords',
                'description' => 'page.skill_consulting.description',
                'title' => 'route.consulting',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.development.keywords',
                'description' => 'page.development.description',
                'title' => 'route.development',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.web.keywords',
                'description' => 'page.web.description',
                'title' => 'route.web',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.mobile.keywords',
                'description' => 'page.mobile.description',
                'title' => 'route.mobile',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.desktop.keywords',
                'description' => 'page.desktop.description',
                'title' => 'route.desktop',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.training.keywords',
                'description' => 'page.training.description',
                'title' => 'route.training',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.application.keywords',
                'description' => 'page.application.description',
                'title' => 'route.application',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.services_consulting.keywords',
                'description' => 'page.services_consulting.description',
                'title' => 'route.consulting',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.services_iot.keywords',
                'description' => 'page.services_iot.description',
                'title' => 'route.iot',
                'image' => '/uploads/pages/test.jpg'
            ],
            [
                'published' => 1,
                'keywords' => 'page.contact.keywords',
                'description' => 'page.contact.description',
                'title' => 'route.contact',
                'image' => '/uploads/pages/test.jpg'
            ],
        ];
        foreach ($pages as $p) {
            $page = new Page();
            $page->setPublished($p['published']);
            $page->setKeywords($p['keywords']);
            $page->setDescription($p['description']);
            $page->setImage($p['image']);
            $page->setTitle($p['title']);
            $page->setSections([1,3,2,3]);
            $manager->persist($page);
            $manager->flush();
        }
    }
}
