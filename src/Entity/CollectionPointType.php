<?php

namespace App\Entity;

use App\Repository\CollectionPointTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CollectionPointTypeRepository::class)
 */
class CollectionPointType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45)
     *    @Assert\Regex(
     *     pattern     = "/^[a-zA-Z0-9()_, -]{3,255}+$/i",
     *     htmlPattern = "^[a-zA-Z0-9()_, -]{3,255}+$",
     *     match=true,
     *     message="Le type du point de collecte peut contenir des lettres majusccules, minuscules, des chiffres, des parenthèses, - , _ , des virgules ou des 
     *      espaces")
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=CollectionPoint::class, mappedBy="collectionPointType")
     */
    private $collectionPoint_id;

    /**
     * @ORM\OneToMany(targetEntity=Material::class, mappedBy="collectionPointType")
     */
    private $materials;

    /**
     * @ORM\OneToMany(targetEntity=Category::class, mappedBy="collectionPointType")
     */
    private $categories;

    public function __construct()
    {
        $this->collectionPoint_id = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|collectionPoint[]
     */
    public function getCollectionPointId(): Collection
    {
        return $this->collectionPoint_id;
    }

    public function addCollectionPointId(collectionPoint $collectionPointId): self
    {
        if (!$this->collectionPoint_id->contains($collectionPointId)) {
            $this->collectionPoint_id[] = $collectionPointId;
            $collectionPointId->setCollectionPointType($this);
        }

        return $this;
    }

    public function removeCollectionPointId(collectionPoint $collectionPointId): self
    {
        if ($this->collectionPoint_id->contains($collectionPointId)) {
            $this->collectionPoint_id->removeElement($collectionPointId);
            // set the owning side to null (unless already changed)
            if ($collectionPointId->getCollectionPointType() === $this) {
                $collectionPointId->setCollectionPointType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Material[]
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials[] = $material;
            $material->setCollectionPointType($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        if ($this->materials->contains($material)) {
            $this->materials->removeElement($material);
            // set the owning side to null (unless already changed)
            if ($material->getCollectionPointType() === $this) {
                $material->setCollectionPointType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setCollectionPointType($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            // set the owning side to null (unless already changed)
            if ($category->getCollectionPointType() === $this) {
                $category->setCollectionPointType(null);
            }
        }

        return $this;
    }
}
