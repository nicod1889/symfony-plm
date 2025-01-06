<?php

namespace App\Entity;

use App\Repository\Persona3Repository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: Persona3Repository::class)]
class Persona3 {
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $nombre;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $apodo = null;

    #[ORM\Column(type: "date")]
    private \DateTimeInterface $nacimiento;

    #[ORM\Column(type: "integer")]
    private int $edad;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $rubro = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $instagram = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $youtube = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static {
        $this->nombre = $nombre;
        return $this;
    }

    public function getApodo(): ?string {
        return $this->apodo;
    }

    public function setApodo(?string $apodo): static {
        $this->apodo = $apodo;
        return $this;
    }

    public function getNacimiento(): \DateTimeInterface {
        return $this->nacimiento;
    }

    public function setNacimiento(\DateTimeInterface $nacimiento): static {
        $this->nacimiento = $nacimiento;
        return $this;
    }

    public function getEdad(): int {
        return $this->edad;
    }

    public function setEdad(int $edad): static {
        $this->edad = $edad;
        return $this;
    }

    public function getFoto(): ?string {
        return $this->foto;
    }

    public function setFoto(?string $foto): static {
        $this->foto = $foto;
        return $this;
    }

    public function getRubro(): ?string {
        return $this->rubro;
    }

    public function setRubro(?string $rubro): static {
        $this->rubro = $rubro;
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
