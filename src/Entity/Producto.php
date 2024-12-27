<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
#[ORM\Index(name: 'product_sku', columns:['sku'])]
#[ORM\Index(name: 'product_price', columns:['price'])]
class Producto {

    #[ORM\Id]
    #[ORM\Column(type: Types::STRING)]
    private ?string $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(min:2, max:100, minMessage:'El nombre del producto debe ser de mínimo 2 caracteres.')]
    private ?string $name = null;

    #[ORM\Column(length: 50)]
    private ?string $sku = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdOn;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private Category $category;

    public function __construct() {
        $this->id = Uuid::v4()->toRfc4122();
        $this->createdOn = new \DateTimeImmutable();
    }

    public function getId(): ?string {
        return $this->id;
    }

    public function getName(): ?string {
        return $this->name;
    }

    public function setName(string $name): static {
        $this->name = $name;
        return $this;
    }

    public function getSku(): ?string {
        return $this->sku;
    }

    public function setSku(string $sku): static {
        $this->sku = $sku;
        return $this;
    }

    public function getPrice(): ?float {
        return $this->price;
    }

    public function setPrice(float $price): static {
        $this->price = $price;
        return $this;
    }

    public function getCreatedOn(): ?\DateTimeImmutable {
        return $this->createdOn;
    }

    public function setCreatedOn(\DateTimeImmutable $createdOn): static {
        $this->createdOn = $createdOn;
        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
    
}
