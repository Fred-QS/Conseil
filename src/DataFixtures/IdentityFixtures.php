<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Identity;

class IdentityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $identity = new Identity();
        $identity->setNameFr('QS Conseil');
        $identity->setNameEn('QS Consulting');
        $identity->setSiren('483345211');
        $identity->setSiret('48334521100039');
        $identity->setAddress('LD Villac');
        $identity->setZip('24100');
        $identity->setCity('Bergerac');
        $identity->setCountry('FRANCE');
        $identity->setApe('6201Z');
        $identity->setPhone('+33662687011');
        $identity->setEmail('contact@frederic-geffray.com');
        $identity->setSloganFr('Accompagner, réaliser, former');
        $identity->setSloganEn('Support, realize, train');
        $manager->persist($identity);

        $manager->flush();
    }
}
