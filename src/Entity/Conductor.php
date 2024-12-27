<?php

namespace App\Entity;

use App\Repository\ConductorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConductorRepository::class)]
class Conductor extends Persona2 {
    #[ORM\Column(type: "date", nullable: true)]
    private ?\DateTime $cumple = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $apodo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    public function getCumple(): ?\DateTime {
        return $this->cumple;
    }

    public function setCumple(?\DateTime $cumple): static {
        $this->cumple = $cumple;
        return $this;
    }

    public function getApodo(): ?string {
        return $this->apodo;
    }

    public function setApodo(?string $apodo): static {
        $this->apodo = $apodo;
        return $this;
    }

    public function getInstagram(): ?string {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): static {
        $this->instagram = $instagram;
        return $this;
    }

    public function getTwitter(): ?string {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): static {
        $this->twitter = $twitter;
        return $this;
    }

    public function getYoutube(): ?string {
        return $this->youtube;
    }

    public function setYoutube(?string $youtube): static {
        $this->youtube = $youtube;
        return $this;
    }
}