<?php

namespace App\Entity;

use App\Repository\EdicionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EdicionRepository::class)]
class Edicion {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    /**
     * @var Collection<int, Programa>
     */
    #[ORM\OneToMany(targetEntity: Programa::class, mappedBy: 'edicionClass')]
    private Collection $programas;

    public function __construct() {
        $this->programas = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Programa>
     */
    public function getProgramas(): Collection {
        return $this->programas;
    }

    public function addPrograma(Programa $programa): static {
        if (!$this->programas->contains($programa)) {
            $this->programas->add($programa);
            $programa->setEdicionClass($this);
        }

        return $this;
    }

    public function removePrograma(Programa $programa): static {
        if ($this->programas->removeElement($programa)) {
            if ($programa->getEdicionClass() === $this) {
                $programa->setEdicionClass(null);
            }
        }

        return $this;
    }
}