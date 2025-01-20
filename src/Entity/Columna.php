<?php

namespace App\Entity;

use App\Repository\ColumnaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColumnaRepository::class)]
class Columna {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $titulo = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    #[ORM\ManyToOne(inversedBy: 'columnas')]
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

    public function getLink(): ?string {
        return $this->link;
    }

    public function setLink(string $link): static {
        $this->link = $link;
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
