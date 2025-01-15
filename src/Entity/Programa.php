<?php

namespace App\Entity;

use App\Repository\ProgramaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProgramaRepository::class)]
class Programa {
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkYoutube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkSpotify = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $miniaturaPequeña = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $miniaturaGrande = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $edicion = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comentario = null;

    #[ORM\ManyToMany(targetEntity: Persona3::class)]
    #[ORM\JoinTable(name: "programa_conductores")]
    private $conductores;

    #[ORM\ManyToMany(targetEntity: Persona3::class)]
    #[ORM\JoinTable(name: "programa_columnistas")]
    private $columnistas;

    #[ORM\ManyToMany(targetEntity: Persona3::class)]
    #[ORM\JoinTable(name: "programa_invitados")]
    private $invitados;

    #[ORM\ManyToOne(inversedBy: 'programas')]
    private ?Edicion $edicionClass = null;

    /**
     * @var Collection<int, Clip>
     */
    #[ORM\OneToMany(targetEntity: Clip::class, mappedBy: 'programa')]
    private Collection $clips;

    public function __construct() {
        $this->conductores = new ArrayCollection();
        $this->columnistas = new ArrayCollection();
        $this->invitados = new ArrayCollection();
        $this->clips = new ArrayCollection();
    }

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

    public function getFecha(): ?\DateTimeInterface {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static {
        $this->fecha = $fecha;
        return $this;
    }

    public function getLinkYoutube(): ?string {
        return $this->linkYoutube;
    }

    public function setLinkYoutube(string $linkYoutube): static {
        $this->linkYoutube = $linkYoutube;
        return $this;
    }

    public function getLinkSpotify(): ?string {
        return $this->linkSpotify;
    }

    public function setLinkSpotify(string $linkSpotify): static {
        $this->linkSpotify = $linkSpotify;
        return $this;
    }

    public function getMiniaturaPequeña(): ?string {
        return $this->miniaturaPequeña;
    }

    public function setMiniaturaPequeña(string $miniaturaPequeña): static {
        $this->miniaturaPequeña = $miniaturaPequeña;
        return $this;
    }

    public function getMiniaturaGrande(): ?string {
        return $this->miniaturaGrande;
    }

    public function setMiniaturaGrande(string $miniaturaGrande): static {
        $this->miniaturaGrande = $miniaturaGrande;
        return $this;
    }

    public function getEdicion(): ?string {
        return $this->edicion;
    }

    public function setEdicion(string $edicion): static {
        $this->edicion = $edicion;
        return $this;
    }

    public function getComentario(): ?string {
        return $this->comentario;
    }

    public function setComentario(string $comentario): static {
        $this->comentario = $comentario;
        return $this;
    }

    public function getConductores(): Collection {
        return $this->conductores;
    }

    public function addConductor(Persona3 $persona): static {
        if (!$this->conductores->contains($persona)) {
            $this->conductores[] = $persona;
        }
        return $this;
    }

    public function getColumnistas(): Collection {
        return $this->columnistas;
    }

    public function addColumnista(Persona3 $persona): static {
        if (!$this->columnistas->contains($persona)) {
            $this->columnistas[] = $persona;
        }
        return $this;
    }

    public function getInvitados(): Collection {
        return $this->invitados;
    }

    public function addInvitado(Persona3 $persona): static {
        if (!$this->invitados->contains($persona)) {
            $this->invitados[] = $persona;
        }
        return $this;
    }

    public function getEdicionClass(): ?Edicion {
        return $this->edicionClass;
    }

    public function setEdicionClass(?Edicion $edicionClass): static {
        $this->edicionClass = $edicionClass;
        return $this;
    }

    /**
     * @return Collection<int, Clip>
     */
    public function getClips(): Collection {
        return $this->clips;
    }

    public function addClip(Clip $clip): static {
        if (!$this->clips->contains($clip)) {
            $this->clips->add($clip);
            $clip->setPrograma($this);
        }
        return $this;
    }

    public function removeClip(Clip $clip): static {
        if ($this->clips->removeElement($clip)) {
            if ($clip->getPrograma() === $this) {
                $clip->setPrograma(null);
            }
        }
        return $this;
    }
}