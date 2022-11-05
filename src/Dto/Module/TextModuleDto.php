<?php

namespace App\Dto\Module;

class TextModuleDto
{
    /**
     * @var string|null
     */
    private ?string $background = null;

    /**
     * @var string|null
     */
    private ?string $title = null;

    /**
     * @var string|null
     */
    private ?string $text = null;

    /**
     * @var array
     */
    private array $buttons = [];

    /**
     * @return string|null
     */
    public function getBackground(): ?string
    {
        return $this->background;
    }

    /**
     * @param string|null $background
     */
    public function setBackground(?string $background): void
    {
        $this->background = $background;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string|null $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string|null $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return array
     */
    public function getButtons(): array
    {
        return $this->buttons;
    }

    /**
     * @param string $name
     * @param string $href
     */
    public function addButtons(string  $name, string $href): void
    {
        $this->buttons[] = [
            'name' => $name,
            'href' => $href
        ];
    }
}