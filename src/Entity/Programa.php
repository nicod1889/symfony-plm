<?php

namespace App\Entity;

use App\Repository\ProgramaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramaRepository::class)]
class Programa {
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255)]
    private ?string $linkYoutube = null;

    #[ORM\Column(length: 255)]
    private ?string $miniatura = null;

    #[ORM\Column(length: 50)]
    private ?string $edicion = null;

    /**
     * @var Collection<int, Conductor>
     */
    #[ORM\ManyToMany(targetEntity: Conductor::class, mappedBy: 'programas')]
    private Collection $conductores;

    /**
     * @var Collection<int, Columnista>
     */
    #[ORM\ManyToMany(targetEntity: Columnista::class, mappedBy: 'programas')]
    private Collection $columnistas;

    public function __construct() {
        $this->conductores = new ArrayCollection();
        $this->columnistas = new ArrayCollection();
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getTitulo(): ?string {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static {
        $this->fecha = $fecha;

        return $this;
    }

    public function getLinkYoutube(): ?string {
        return $this->linkYoutube;
    }

    public function setLinkYoutube(string $linkYoutube): static {
        $this->linkYoutube = $linkYoutube;

        return $this;
    }

    public function getMiniatura(): ?string {
        return $this->miniatura;
    }

    public function setMiniatura(string $miniatura): static {
        $this->miniatura = $miniatura;

        return $this;
    }

    public function getEdicion(): ?string {
        return $this->edicion;
    }

    public function setEdicion(string $edicion): static {
        $this->edicion = $edicion;

        return $this;
    }

    /**
     * @return Collection<int, Conductor>
     */
    public function getConductores(): Collection {
        return $this->conductores;
    }

    public function addConductor(Conductor $conductor): static {
        if (!$this->conductores->contains($conductor)) {
            $this->conductores->add($conductor);
            $conductor->addPrograma($this);
        }
        return $this;
    }

    public function removeConductor(Conductor $conductor): static {
        if ($this->conductores->removeElement($conductor)) {
            $conductor->removePrograma($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Columnista>
     */
    public function getColumnistas(): Collection {
        return $this->columnistas;
    }

    public function addColumnista(Columnista $columnista): static {
        if (!$this->columnistas->contains($columnista)) {
            $this->columnistas->add($columnista);
            $columnista->addPrograma($this);
        }
        return $this;
    }

    public function removeColumnista(Columnista $columnista): static {
        if ($this->columnistas->removeElement($columnista)) {
            $columnista->removePrograma($this);
        }
        return $this;
    }
}