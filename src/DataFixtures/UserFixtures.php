<?php

namespace App\DataFixtures;

use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher) {}

    public function load(ObjectManager $manager, ): void
    {
        $user = new User();
        $plaintextPassword = 'lespaul96';
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setCivility('M');
        $user->setFirstname('Frédéric');
        $user->setLastname('Geffray');
        $user->setPhone('+33662687011');
        $user->setEmail('fred.geffray@gmail.com');
        $user->setBirthdate(new DateTime('1979-12-05'));
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($hashedPassword);
        $manager->persist($user);

        $manager->flush();
    }
}
