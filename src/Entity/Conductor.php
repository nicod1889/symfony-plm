<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, Programa>
     */
    #[ORM\ManyToMany(targetEntity: Programa::class, inversedBy: 'conductores')]
    private Collection $programas;

    public function __construct() {
        $this->programas = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Programa>
     */
    public function getProgramas(): Collection {
        return $this->programas;
    }

    public function addPrograma(Programa $programa): static {
        if (!$this->programas->contains($programa)) {
            $this->programas->add($programa);
            $programa->addConductor($this);
        }

        return $this;
    }

    public function removePrograma(Programa $programa): static {
        $this->programas->removeElement($programa);

        return $this;
    }
}