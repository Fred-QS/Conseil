<?php

namespace App\SeoStrategy;

use DonatelloZa\RakePlus\RakePlus;

class Formater
{
    public function setKeywords(string $text, string $language): string
    {
        $locale = ($language === 'fr') ? 'fr_FR' : 'en_US';
        $rake = RakePlus::create($text, $locale);
        $keywords = $rake->keywords();
        $finals = [];
        foreach ($keywords as $keyword) {
            $keyword = str_replace("’", '', $keyword);
            if (preg_match('/^[\w.-]+$/u', $keyword)) {
                $finals[] = $keyword;
            } else {
                $extracts[] = $keyword;
            }
        }
        if (count($finals) > 15) {
            while (count($finals) > 15) {
                array_pop($finals);
            }
        }
        return implode(',', $finals);
    }

    public function setSeoContent(string $text, string|array $keywords): string
    {
        $kws = (!is_array($keywords)) ? explode(',', $keywords) : $keywords;
        $lowerText = strtolower($text);
        foreach ($kws as $kw) {
            $k = trim($kw);
            $majK = ucfirst($k);
            $upper = strtoupper($k);
            $text = preg_replace(
                ['/\b' . $k . '\b/', '/\b' . $majK . '\b/', '/\b' . $upper . '\b/'],
                ['<strong>' . $k . '</strong>', '<strong>' . $majK . '</strong>', '<strong>' . $upper . '</strong>'],
                $text
            );
        }
        return $text;
    }
}