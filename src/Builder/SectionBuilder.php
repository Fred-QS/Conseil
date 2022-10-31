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
            throw new ErrorException('Section must be defined before id being set.');
        }
        $this->selected['id'] = $id;
        return $this;
    }

    /**
     * @throws ErrorException
     */
    public function setData(array $data): self
    {
        if ($this->selected === null) {
            throw new ErrorException('Section must be defined before data being set.');
        }
        foreach ($data as $key => $row) {
            if (isset($this->selected['blocks'][$key])) {
                $this->selected['blocks'][$key]['module'] = $row['module'];
                $this->selected['blocks'][$key]['content'] = $row['content'];
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
            'title' => $this->selected['title'] . '.html.twig',
            'blocks' => $this->selected['blocks']
        ];
    }
}