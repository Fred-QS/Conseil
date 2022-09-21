<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class RouteExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('set_stimulus', [$this, 'setStimulus']),
            new TwigFunction('splitter', [$this, 'splitter']),
        ];
    }

    public function splitter(string $route): string
    {
        $explode = explode('_', $route);
        $item = $explode[0];
        if (isset($explode[1]) && $explode[1] !== 'index') {
            $item =  $explode[1];
        }
        return $item;
    }

    public function setStimulus(string $route): string
    {
        $item = ($route === 'index') ? 'home' : $route;
        $item = (str_starts_with($item, 'blog')) ? 'article' : $item;
        if ($item !== 'home' && $item !== 'article') {
            $explode = explode('_', $route);
            $item = $explode[0];
        }
        return $item;
    }
}
