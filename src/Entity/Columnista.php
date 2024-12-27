<?php

namespace App\Entity;

use App\Repository\ColumnistaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColumnistaRepository::class)]
class Columnista extends Persona2 {
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $apodo = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $columna = null;

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
}