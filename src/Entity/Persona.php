<?php

namespace App\Entity;

use App\Repository\PersonaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonaRepository::class)]
class Persona {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    private ?string $apellido = null;

    #[ORM\Column(length: 50)]
    private ?int $dni = null;

    #[ORM\Column]
    private ?int $edad = null;

    #[ORM\ManyToOne(inversedBy: 'personas')]
    private ?Club $club = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): ?string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string {
        return $this->apellido;
    }

    public function setApellido(string $apellido): static {
        $this->apellido = $apellido;

        return $this;
    }

    public function getDni(): ?int {
        return $this->dni;
    }

    public function setDni(int $dni): static {
        $this->dni = $dni;

        return $this;
    }

    public function getEdad(): ?int {
        return $this->edad;
    }

    public function setEdad(int $edad): static {
        $this->edad = $edad;

        return $this;
    }

    public function getClub(): ?Club
    {
        return $this->club;
    }

    public function setClub(?Club $club): static
    {
        $this->club = $club;

        return $this;
    }
}
