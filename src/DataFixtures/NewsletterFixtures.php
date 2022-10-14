<?php

namespace App\DataFixtures;

use App\Entity\Newsletter;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class NewsletterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $newsletter = new Newsletter();
        $newsletter->setEmail('fred.geffray@gmail.com');
        $newsletter->setLang('fr');
        $newsletter->setCreatedAt(new DateTimeImmutable());
        $manager->persist($newsletter);

        $manager->flush();
    }
}
