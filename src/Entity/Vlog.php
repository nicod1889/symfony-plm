<?php

namespace App\Entity;

use App\Repository\VlogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VlogRepository::class)]
class Vlog {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $miniatura = null;

    #[ORM\ManyToOne(inversedBy: 'vlogs')]
    private ?Edicion $edicion = null;

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

    public function getMiniatura(): ?string {
        return $this->miniatura;
    }

    public function setMiniatura(string $miniatura): static {
        $this->miniatura = $miniatura;
        return $this;
    }

    public function getEdicion(): ?Edicion {
        return $this->edicion;
    }

    public function setEdicion(?Edicion $edicion): static {
        $this->edicion = $edicion;
        return $this;
    }
}