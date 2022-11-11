<?php

namespace App\Twig;

use Symfony\Component\Form\Form;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Builder\FormBuilder;

class BuilderExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('image_alt', [$this, 'imageAlt'], ['is_safe' => ['html']]),
            new TwigFilter('words_counter', [$this, 'wordsCounter'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('sections_provider', [$this, 'sectionsProvider']),
            new TwigFunction('section_provider', [$this, 'sectionProvider']),
            new TwigFunction('modules_provider', [$this, 'modulesProvider']),
        ];
    }

    public function sectionsProvider(): array
    {
        $formBuilder = new FormBuilder();
        return $formBuilder->getSectionsList();
    }

    public function sectionProvider(int $type): array
    {
        $formBuilder = new FormBuilder();
        return $formBuilder->getSection($type);
    }

    public function modulesProvider(): array
    {
        $formBuilder = new FormBuilder();
        return $formBuilder->getModulesList();
    }

    public function imageAlt(string $value): string
    {
        $split = explode('/', $value);
        $last = end($split);
        $split2 = explode('.', $last);
        return $split2[0];
    }

    public function wordsCounter(string $value, int $wordsNb): string
    {
        $split = explode(' ', $value);
        $count = count($split);
        if ($count > $wordsNb) {
            $final = [];
            $cnt = 0;
            while ($cnt < $wordsNb) {
                $final[] = $split[$cnt];
                $cnt++;
            }
            return implode(' ', $final) . '...';
        }
        return $value;
    }
}
