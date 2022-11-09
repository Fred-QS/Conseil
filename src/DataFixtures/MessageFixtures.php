<?php

namespace App\DataFixtures;

use App\Entity\Message;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTimeImmutable;

class MessageFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $message = new Message();
        $manager->persist($message);
        $message->setName('Fred');
        $message->setEmail('in-touch-fg@quanticalsolutions.com');
        $message->setSubject('Test de sujet');
        $message->setContent('Bla bla bla');
        $message->setCreatedAt(new DateTimeImmutable());
        $message->setSeen(0);
        $manager->flush();
    }
}
