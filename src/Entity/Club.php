<?php

namespace App\Entity;

use App\Repository\ClubRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClubRepository::class)]
class Club {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $city = null;

    #[ORM\Column]
    private ?int $socios = null;

    /**
     * @var Collection<int, Persona>
     */
    #[ORM\OneToMany(targetEntity: Persona::class, mappedBy: 'club', orphanRemoval: true)]
    private Collection $personas;

    public function __construct() {
        $this->personas = new ArrayCollection();
        $this->socios = $this->getPersonas()->count();
    }

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

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(string $city): static {
        $this->city = $city;
        return $this;
    }

    public function getSocios(): ?int {
        return $this->socios;
    }

    public function setSocios(): static {
        $this->socios = $this->getPersonas()->count();
        return $this;
    }

    /**
     * @return Collection<int, Persona>
     */
    public function getPersonas(): Collection {
        return $this->personas;
    }

    public function addPersona(Persona $persona): static {
        if (!$this->personas->contains($persona)) {
            $this->personas->add($persona);
            $persona->setClub($this);
        }
        return $this;
    }

    public function removePersona(Persona $persona): static {
        if ($this->personas->removeElement($persona)) {
            if ($persona->getClub() === $this) {
                $persona->setClub(null);
            }
        }
        return $this;
    }
}
