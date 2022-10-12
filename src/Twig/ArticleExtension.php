<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class ArticleExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('split_content', [$this, 'splitContent', 'is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('display_categories', [$this, 'displayCategories']),
        ];
    }

    public function displayCategories(string $cats): array
    {
        $array = explode(',', $cats);
        $final = [];
        foreach ($array as $item) {
            $final[] = ucfirst(trim($item));
        }
        if (count($final) > 1) {
            return ['label' => 'label.categories', 'data' => implode(', ', $final)];
        }
        return ['label' => 'label.category', 'data' => implode(', ', $final)];
    }

    public function splitContent($value): array
    {
        $chunk = explode('. ', trim($value));
        $middle = (int) ceil((count($chunk)-1)/2);
        $firstPart = [];
        $lastPart = [];
        $cnt = 0;
        foreach ($chunk as $row) {
            if ($cnt <= $middle) {
                $firstPart[] = trim($row);
            } else {
                $lastPart[] = trim($row);
            }
            $cnt++;
        }

        return [
            implode('. ', $firstPart) . '.',
            implode('. ', $lastPart)
        ];
    }
}
