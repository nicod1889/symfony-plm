<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\ColumnistaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColumnistaRepository::class)]
class Columnista extends Persona2 {
    
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $apodo = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $columna = null;

    /**
     * @var Collection<int, Programa>
     */
    #[ORM\ManyToMany(targetEntity: Programa::class, inversedBy: 'columnistas')]
    private Collection $programas;

    public function __construct() {
        $this->programas = new ArrayCollection();
    }

    public function getApodo(): ?string {
        return $this->apodo;
    }

    public function setApodo(?string $apodo): static {
        $this->apodo = $apodo;
        return $this;
    }

    public function getColumna(): ?string {
        return $this->columna;
    }

    public function setColumna(?string $columna): static {
        $this->columna = $columna;
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
            $programa->addColumnista($this);
        }

        return $this;
    }

    public function removePrograma(Programa $programa): static {
        $this->programas->removeElement($programa);

        return $this;
    }
}