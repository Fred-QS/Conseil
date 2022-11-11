<?php

namespace App\Builder;

use App\Form\Module\TextFormType;
use App\Form\Module\ImageFormType;
use App\Form\Module\SubModule\ButtonFormType;
use App\Entity\Block;
use Symfony\Component\Yaml\Yaml;

class FormBuilder
{
    public function setData(array $page, string $locale): array
    {
        $title = $page['title'];
        $background = $page['background'];
        $sections = [];

        foreach ($page['sections'] as $section) {

            /**@var Block $section */
            $index = $section->getSectionOrder()-1;
            if (!isset($sections[$index])) {
                $sections[$index] = [
                    'type' => $section->getSection(),
                    'blocks' => []
                ];
            }
            $content = 'getContent' . ucfirst($locale);
            $sections[$index]['blocks'][] = [
                'content' => $section->$content(),
                'order' => $section->getBlockOrder(),
                'module' => $section->getModule()
            ];
        }

        return ['title' => $title, 'background' => $background, 'sections' => $sections];
    }

    public function getSectionsList(): array
    {
        $path = dirname(__DIR__, 2) . '/data/sections.yaml';
        $sections = Yaml::parseFile($path, Yaml::PARSE_CONSTANT);
        $all = [];
        foreach ($sections as $section) {
            $all[] = ['name' => $section['title'], 'type' => $section['ref'], 'dimensions' => $section['dimensions']];
        }
        return $all;
    }

    public function getSection(int $type): ?array
    {
        $sections = $this->getSectionsList();
        foreach ($sections as $section) {
            if ($section['type'] === $type) {
                return $section;
            }
        }
        return null;
    }

    public function getModulesList(): array
    {
        $all = [];
        $path = dirname(__DIR__, 2) . '/templates/_macros/_builder/_blocks';
        $excepts = ['.', '..', '.gitignore'];
        foreach (scandir($path) as $module) {
            if (!in_array($module, $excepts, true)) {
                $all[] = [
                    'title' => ucfirst(str_replace('.html.twig', '', $module)),
                    'path' => '_macros/_builder/_blocks/' . $module
                ];
            }
        }
        return $all;
    }
}