<?php

namespace App\Entity;

use App\Repository\ProgramaRepository;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getLinkYoutube(): ?string
    {
        return $this->link;
    }

    public function setLinkYoutube(string $link): static
    {
        $this->link = $link;

        return $this;
    }

    public function getMiniatura(): ?string
    {
        return $this->miniatura;
    }

    public function setMiniatura(string $miniatura): static
    {
        $this->miniatura = $miniatura;

        return $this;
    }

    public function getEdicion(): ?string
    {
        return $this->edicion;
    }

    public function setEdicion(string $edicion): static
    {
        $this->edicion = $edicion;

        return $this;
    }
}