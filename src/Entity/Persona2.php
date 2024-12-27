<?php

namespace App\Entity;

use App\Repository\Persona2Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Persona2Repository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "tipo", type: "string")]
#[ORM\DiscriminatorMap([
    "persona" => Persona2::class,
    "conductor" => Conductor::class,
    "columnista" => Columnista::class,
    "invitado" => Invitado::class,
])]
class Persona2 {
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $nombre = null;

    #[ORM\Column(length: 50)]
    private ?string $apellido = null;

    #[ORM\Column]
    private ?int $edad = null;

    #[ORM\Column(length: 255)]
    private ?string $foto = null;

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

    public function getEdad(): ?int {
        return $this->edad;
    }

    public function setEdad(int $edad): static {
        $this->edad = $edad;
        return $this;
    }

    public function getFoto(): ?string {
        return $this->foto;
    }

    public function setFoto(string $foto): static {
        $this->foto = $foto;
        return $this;
    }
}
