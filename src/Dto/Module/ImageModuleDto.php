<?php

namespace App\Dto\Module;

class ImageModuleDto
{
    /**
     * @var string|null
     */
    private ?string $link = null;

    /**
     * @var string|null
     */
    private ?string $src = null;

    /**
     * @var string|null
     */
    private ?string $alt = null;

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string|null $link
     */
    public function setLink(?string $link): void
    {
        $this->link = $link;
    }

    /**
     * @return string|null
     */
    public function getSrc(): ?string
    {
        return $this->src;
    }

    /**
     * @param string|null $src
     */
    public function setSrc(?string $src): void
    {
        $this->src = $src;
    }

    /**
     * @return string|null
     */
    public function getAlt(): ?string
    {
        return $this->alt;
    }

    /**
     * @param string|null $alt
     */
    public function setAlt(?string $alt): void
    {
        $this->alt = $alt;
    }
}