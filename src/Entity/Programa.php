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

    #[ORM\ManyToMany(targetEntity: Persona3::class)]
    #[ORM\JoinTable(name: "programa_conductores")]
    private $conductores;

    #[ORM\ManyToMany(targetEntity: Persona3::class)]
    #[ORM\JoinTable(name: "programa_columnistas")]
    private $columnistas;

    #[ORM\ManyToMany(targetEntity: Persona3::class)]
    #[ORM\JoinTable(name: "programa_invitados")]
    private $invitados;

    public function __construct() {
        $this->conductores = new ArrayCollection();
        $this->columnistas = new ArrayCollection();
        $this->invitados = new ArrayCollection();
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

    public function getConductores(): Collection {
        return $this->conductores;
    }

    public function addConductor(Persona3 $persona): static {
        if (!$this->conductores->contains($persona)) {
            $this->conductores[] = $persona;
        }

        return $this;
    }

    public function getColumnistas(): Collection {
        return $this->columnistas;
    }

    public function addColumnista(Persona3 $persona): static {
        if (!$this->columnistas->contains($persona)) {
            $this->columnistas[] = $persona;
        }

        return $this;
    }

    public function getInvitados(): Collection {
        return $this->invitados;
    }

    public function addInvitado(Persona3 $persona): static {
        if (!$this->invitados->contains($persona)) {
            $this->invitados[] = $persona;
        }

        return $this;
    }
}