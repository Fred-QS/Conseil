<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('str_replace', [$this, 'strReplace']),
            new TwigFunction('set_stimulus', [$this, 'setStimulus']),
        ];
    }

    public function strReplace(string $search, string $replace, string $original): string
    {
        return str_replace($search, $replace, $original);
    }

    public function setStimulus(string $route): string
    {
        $route = ($route === 'index') ? 'home' : $route;
        return str_replace(['info_'], '', $route);
    }
}
