<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $devenir;

    /**
     * @ORM\OneToMany(targetEntity=Objet::class, mappedBy="Use_id", orphanRemoval=true)
     */
    private $objets;

    /**
     * @ORM\ManyToMany(targetEntity=CollectionPoint::class, mappedBy="category_has_collectionPoint")
     */
    private $collectionPoints;

    public function __construct()
    {
        $this->objets = new ArrayCollection();
        $this->collectionPoints = new ArrayCollection();
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

    public function getDevenir(): ?string
    {
        return $this->devenir;
    }

    public function setDevenir(?string $devenir): self
    {
        $this->devenir = $devenir;

        return $this;
    }

    /**
     * @return Collection|Objet[]
     */
    public function getObjets(): Collection
    {
        return $this->objets;
    }

    public function addObjet(Objet $objet): self
    {
        if (!$this->objets->contains($objet)) {
            $this->objets[] = $objet;
            $objet->setUseId($this);
        }

        return $this;
    }

    public function removeObjet(Objet $objet): self
    {
        if ($this->objets->contains($objet)) {
            $this->objets->removeElement($objet);
            // set the owning side to null (unless already changed)
            if ($objet->getUseId() === $this) {
                $objet->setUseId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|CollectionPoint[]
     */
    public function getCollectionPoints(): Collection
    {
        return $this->collectionPoints;
    }

    public function addCollectionPoint(CollectionPoint $collectionPoint): self
    {
        if (!$this->collectionPoints->contains($collectionPoint)) {
            $this->collectionPoints[] = $collectionPoint;
            $collectionPoint->addCategoryHasCollectionPoint($this);
        }

        return $this;
    }

    public function removeCollectionPoint(CollectionPoint $collectionPoint): self
    {
        if ($this->collectionPoints->contains($collectionPoint)) {
            $this->collectionPoints->removeElement($collectionPoint);
            $collectionPoint->removeCategoryHasCollectionPoint($this);
        }

        return $this;
    }
}
