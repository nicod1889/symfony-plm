<?php

namespace App\Entity;

use App\Repository\EdificioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EdificioRepository::class)]
class Edificio {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $street = null;

    #[ORM\Column]
    private ?int $numberStreet = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;
        return $this;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function setStreet(string $street): static {
        $this->street = $street;
        return $this;
    }

    public function getNumberStreet(): ?int {
        return $this->numberStreet;
    }

    public function setNumberStreet(int $numberStreet): static {
        $this->numberStreet = $numberStreet;
        return $this;
    }
}
