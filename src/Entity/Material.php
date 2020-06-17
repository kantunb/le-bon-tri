<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MaterialRepository::class)
 */
class Material
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     *    @Assert\Regex(
     *     pattern     = "/^[a-zA-Z0-9()_, -]{3,255}+$/i",
     *     htmlPattern = "^[a-zA-Z0-9()_, -]{3,255}+$",
     *     match=true,
     *     message="Le nom du point de collecte peut contenir des lettres majusccules, minuscules, des chiffres, des parenthèses, - , _ , des virgules ou des espaces"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $devenir;

    /**
     * @ORM\OneToMany(targetEntity=Objet::class, mappedBy="Material_id", orphanRemoval=true)
     */
    private $objets;

    /**
     * @ORM\ManyToMany(targetEntity=CollectionPoint::class, mappedBy="material_has_collectionPoint")
     */
    private $collectionPoints;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionPointType::class, inversedBy="materials")
     */
    private $collectionPointType;

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
            $objet->setMaterialId($this);
        }

        return $this;
    }

    public function removeObjet(Objet $objet): self
    {
        if ($this->objets->contains($objet)) {
            $this->objets->removeElement($objet);
            // set the owning side to null (unless already changed)
            if ($objet->getMaterialId() === $this) {
                $objet->setMaterialId(null);
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
            $collectionPoint->addMaterialHasCollectionPoint($this);
        }

        return $this;
    }

    public function removeCollectionPoint(CollectionPoint $collectionPoint): self
    {
        if ($this->collectionPoints->contains($collectionPoint)) {
            $this->collectionPoints->removeElement($collectionPoint);
            $collectionPoint->removeMaterialHasCollectionPoint($this);
        }

        return $this;
    }

    public function getCollectionPointType(): ?CollectionPointType
    {
        return $this->collectionPointType;
    }

    public function setCollectionPointType(?CollectionPointType $collectionPointType): self
    {
        $this->collectionPointType = $collectionPointType;

        return $this;
    }
}
