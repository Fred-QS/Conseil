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
            new TwigFunction('set_error_syntax', [$this, 'setErrorSyntax']),
            new TwigFunction('to_translation', [$this, 'toTranslation']),
            new TwigFunction('parse_translated_route', [$this, 'parseTranslatedRoute']),
            new TwigFunction('set_article_main_class', [$this, 'setArticleMainClass']),
            new TwigFunction('is_active', [$this, 'isActive']),
        ];
    }

    public function parseTranslatedRoute(string $route): string
    {
        if ($route === 'blog_article') {
            return 'blog_index';
        }
        return $route;
    }

    public function toTranslation(string $text): string
    {
        return 'errors.' . strtolower(str_replace(' ', '_', $text));
    }

    public function setErrorSyntax(int $code, string $title, string $lang): string
    {
        return ($lang === 'fr') ? $title . ' ' . $code : $code . ' ' . $title;
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

    public function setArticleMainClass(string $route): string
    {
        return ($route === 'blog_article') ? ' class="alt"' : '';
    }

    public function isActive(string $route, string $ref, bool $global = false): string
    {
        if (true === $global) {
            return str_starts_with($route, $ref) === true ? 'active' : '';
        }

        return $route === $ref ? 'active' : '';
    }
}
