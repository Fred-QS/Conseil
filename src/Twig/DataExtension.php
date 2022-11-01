<?php

namespace App\Twig;

use Doctrine\ORM\EntityManagerInterface;
use JsonException;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Identity;
use Symfony\Component\Yaml\Yaml;

class DataExtension extends AbstractExtension
{
    public function __construct(private EntityManagerInterface $entityManager) {}

    public function getFunctions(): array
    {
        return [
            new TwigFunction('society_data', [$this, 'societyData']),
            new TwigFunction('ordered_blocks', [$this, 'orderedBlocks']),
            new TwigFunction('provide_bg', [$this, 'provideBg']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('filtered_text', [$this, 'filteredText']),
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
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

    public function filteredText(array $text): string
    {
        $title = $text['title'];
        $calls = $text['buttons'];
        $content = $text['text'];

        $render = $title !== ''
            ? sprintf('<header class="major">%s</header>', $title)
            : null;

        $render .= $content;

        if (!empty($calls)) {
            $render .= '<ul class="actions">';
            foreach ($calls as $call) {
                $render .= sprintf('<li><a class="button" href="%s">%s</a></li>', $call['href'], $call['name']);
            }
            $render .= '</ul>';
        }

        return $render;
    }

    public function provideBg(string $route): string
    {
        $path = dirname(__DIR__, 2).'/data/backgrounds.yaml';
        $bgs = Yaml::parseFile($path, Yaml::PARSE_CONSTANT);
        return $bgs[$route] ?? 'home.jpg';
    }

    /**
     * @throws JsonException
     */
    public function jsonDecode(string $value): array
    {
        return \json_decode($value, true, 512, JSON_THROW_ON_ERROR);
    }
}
