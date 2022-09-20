<?php

namespace App\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use App\Entity\Identity;

class DataExtension extends AbstractExtension
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('society_data', [$this, 'societyData']),
        ];
    }

    public function societyData(): Identity
    {
        return $this->entityManager->getRepository(Identity::class)->find(1);
    }
}
