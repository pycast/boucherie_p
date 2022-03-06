<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $slug;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $illustration;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $recipe;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $subtitle;

    #[ORM\Column(type: 'boolean')]
    private $visible;

    #[ORM\Column(type: 'boolean')]
    private $order_online_open;

    #[ORM\OneToOne(mappedBy: 'product', targetEntity: Recipe::class, cascade: ['persist', 'remove'])]
    private $recipe_associated;

    #[ORM\Column(type: 'string', length: 255)]
    private $unit;

    public function __toString()
    {
        return $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getRecipe(): ?string
    {
        return $this->recipe;
    }

    public function setRecipe(?string $recipe): self
    {
        $this->recipe = $recipe;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(?string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }

    public function getOrderOnlineOpen(): ?bool
    {
        return $this->order_online_open;
    }

    public function setOrderOnlineOpen(bool $order_online_open): self
    {
        $this->order_online_open = $order_online_open;

        return $this;
    }

    public function getRecipeAssociated(): ?Recipe
    {
        return $this->recipe_associated;
    }

    public function setRecipeAssociated(Recipe $recipe_associated): self
    {
        // set the owning side of the relation if necessary
        if ($recipe_associated->getProduct() !== $this) {
            $recipe_associated->setProduct($this);
        }

        $this->recipe_associated = $recipe_associated;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }
}
