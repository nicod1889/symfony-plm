<?php

namespace App\Entity;

use App\Repository\InvitadoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InvitadoRepository::class)]
class Invitado extends Persona2 {
    #[ORM\Column(length: 50, nullable: true)]
    private ?string $apodo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rubro = null;

    public function getApodo(): ?string {
        return $this->apodo;
    }

    public function setApodo(?string $apodo): static {
        $this->apodo = $apodo;
        return $this;
    }

    public function getRubro(): ?string {
        return $this->rubro;
    }

    public function setRubro(?string $rubro): static {
        $this->rubro = $rubro;
        return $this;
    }
}