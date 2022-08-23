<?php

namespace App\Entity\Trait;

use Doctrine\ORM\Mapping as ORM;

trait SlugTrait
{
    #[ORM\Column(length: 190, unique: true)]
    private $slug = null;

    public function getSlug(): ?string
    {
        return $this->created_at;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;  
    }
}