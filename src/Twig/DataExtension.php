<?php

namespace App\Twig;

use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Identity;

class DataExtension extends AbstractExtension
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('society_data', [$this, 'societyData']),
            new TwigFunction('ordered_blocks', [$this, 'orderedBlocks']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('filtered_text', [$this, 'filteredText']),
        ];
    }

    public function societyData(): Identity
    {
        return $this->entityManager->getRepository(Identity::class)->find(1);
    }

    public function orderedBlocks(array $blocks): array
    {
        $sort = array_column($blocks, 'order');
        array_multisort($sort, SORT_ASC, $blocks);
        return $blocks;
    }

    public function filteredText(string $text): string
    {
        $calls = [];
        $title = null;

        $render = $title !== null && $title !== ''
            ? sprintf('<header class="major"><h2>%s</h2></header>', $title)
            : null;

        $render .= $text;

        if (!empty($calls)) {
            $render .= '<ul class="actions">';
            foreach ($calls as $call) {
                $render .= sprintf('<li><a class="button" href="%s">%s</a></li>', $call['href'], $call['text']);
            }
            $render .= '</ul>';
        }

        return $render;
    }
}
