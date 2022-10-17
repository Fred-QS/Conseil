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
            throw new ErrorException('$ref parameter must have a value between 1 and ' . count($this->templates) . '.');
        }
        return $this;
    }

    /**
     * @throws ErrorException
     */
    public function setId(string $id): self
    {
        if ($this->selected === null) {
            throw new ErrorException('Section must be defined before being rendered.');
        }
        $this->selected['id'] = $id;
        return $this;
    }

    /**
     * @throws ErrorException
     */
    public function setClass(array $class): self
    {
        if ($this->selected === null) {
            throw new ErrorException('Section must be defined before being rendered.');
        }
        $defined = $this->selected['class'];
        $defined[] = $this->selected['title'] . '-section';
        $merged = array_merge($defined, $class);
        $this->selected['class'] = array_unique($merged);
        return $this;
    }

    /**
     * @throws ErrorException
     */
    public function setData(array $data): self
    {
        if ($this->selected === null) {
            throw new ErrorException('Section must be defined before being rendered.');
        }
        foreach ($data as $key => $row) {
            if (isset($this->selected['blocks'][$key])) {
                $this->selected['blocks'][$key]['fr'] = $row['fr'];
                $this->selected['blocks'][$key]['en'] = $row['en'];
                $this->selected['blocks'][$key]['module'] = $row['module'];
            }
        }
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
        return [
            'id' => $this->selected['id'],
            'class' => implode(' ', $this->selected['class']),
            'blocks' => $this->selected['blocks']
        ];
    }
}