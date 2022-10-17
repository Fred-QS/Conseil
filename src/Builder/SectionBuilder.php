<?php

namespace App\Builder;

use ErrorException;
use Symfony\Component\Yaml\Yaml;

class SectionBuilder
{
    private array $templates;
    private ?array $selected;

    public function __construct()
    {
        $path = dirname(__DIR__, 2).'/data/sections.yaml';
        $this->templates = Yaml::parseFile($path, Yaml::PARSE_CONSTANT);
    }

    /**
     * @throws ErrorException
     */
    public function setSection(int $ref): self
    {
        if ($ref > 0 && $ref <= 6) {
            foreach ($this->templates as $template) {
                if ($template['ref'] === $ref) {
                    $this->selected = $template;
                    break;
                }
            }
        } else {
            throw new ErrorException('$ref parameter must have a value between 1 and 6.');
        }
        return $this;
    }

    public function setId(string $id): self
    {
        $this->selected['id'] = $id;
        return $this;
    }

    public function setClass(array $class): self
    {
        $defined = $this->selected['class'];
        $merged = array_merge($defined, $class);
        $this->selected['class'] = array_unique($merged);
        return $this;
    }

    /**
     * @throws ErrorException
     */
    public function render(): array
    {
        if ($this->selected === null) {
            throw new ErrorException('Section must be defined before being rendered.');
        }
        return $this->selected;
    }
}