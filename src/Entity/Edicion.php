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

    #[ORM\Column(length: 50)]
    private ?string $tipo = null;

    /**
     * @var Collection<int, Programa>
     */
    #[ORM\OneToMany(targetEntity: Programa::class, mappedBy: 'edicionClass')]
    private Collection $programas;

    /**
     * @var Collection<int, Vlog>
     */
    #[ORM\OneToMany(targetEntity: Vlog::class, mappedBy: 'edicion')]
    private Collection $vlogs;

    public function __construct() {
        $this->programas = new ArrayCollection();
        $this->vlogs = new ArrayCollection();
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

    public function getTipo(): ?string {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static {
        $this->tipo = $tipo;

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
            // set the owning side to null (unless already changed)
            if ($programa->getEdicionClass() === $this) {
                $programa->setEdicionClass(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vlog>
     */
    public function getVlogs(): Collection
    {
        return $this->vlogs;
    }

    public function addVlog(Vlog $vlog): static
    {
        if (!$this->vlogs->contains($vlog)) {
            $this->vlogs->add($vlog);
            $vlog->setEdicion($this);
        }

        return $this;
    }

    public function removeVlog(Vlog $vlog): static
    {
        if ($this->vlogs->removeElement($vlog)) {
            // set the owning side to null (unless already changed)
            if ($vlog->getEdicion() === $this) {
                $vlog->setEdicion(null);
            }
        }

        return $this;
    }
}