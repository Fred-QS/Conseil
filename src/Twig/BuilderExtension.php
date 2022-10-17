<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class BuilderExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('image_alt', [$this, 'imageAlt'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('build', [$this, 'build']),
        ];
    }

    public function build($value): string
    {
        return '';
    }

    public function imageAlt(string $value): string
    {
        $split = explode('/', $value);
        $last = end($split);
        $split2 = explode('.', $last);
        return $split2[0];
    }
}
