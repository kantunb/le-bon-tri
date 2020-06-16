<?php

namespace App\Entity;

use App\Repository\CollectionPointRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CollectionPointRepository::class)
 */
class CollectionPoint
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
     * @ORM\Column(type="string", length=45)
     *     @Assert\Regex(
     *     pattern     = "/^[a-zA-Z0-9 ]{3,255}+$/i",
     *     htmlPattern = "^[a-zA-Z0-9 ]{3,255}+$",
     *     match=true,
     *     message="Le nom du point de collecte peut contenir des lettres majusccules, minuscules et des chiffres")
     * 
     */
    private $streetNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $streetName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coordinateX;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $coordinateY;

    /**
     * @ORM\Column(type="text")
     */
    private $openingTime;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $review;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\ManyToOne(targetEntity=CollectionPointType::class, inversedBy="collectionPoint_id")
     * @ORM\JoinColumn(nullable=false)
     */
    private $collectionPointType;

    /**
     * @ORM\ManyToMany(targetEntity=Material::class, inversedBy="collectionPoints")
     */
    private $material_has_collectionPoint;

    /**
     * @ORM\ManyToMany(targetEntity=Objet::class, inversedBy="collectionPoints")
     */
    private $objet_has_collectionPoint;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="collectionPoints")
     */
    private $category_has_collectionPoint;

    public function __construct()
    {
        $this->material_has_collectionPoint = new ArrayCollection();
        $this->objet_has_collectionPoint = new ArrayCollection();
        $this->category_has_collectionPoint = new ArrayCollection();
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

    public function getStreetNumber(): ?string
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(string $streetNumber): self
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreetName(): ?string
    {
        return $this->streetName;
    }

    public function setStreetName(string $streetName): self
    {
        $this->streetName = $streetName;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCoordinateX(): ?float
    {
        return $this->coordinateX;
    }

    public function setCoordinateX(?float $coordinateX): self
    {
        $this->coordinateX = $coordinateX;

        return $this;
    }

    public function getCoordinateY(): ?float
    {
        return $this->coordinateY;
    }

    public function setCoordinateY(?float $coordinateY): self
    {
        $this->coordinateY = $coordinateY;

        return $this;
    }

    public function getOpeningTime(): ?string
    {
        return $this->openingTime;
    }

    public function setOpeningTime(string $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getReview(): ?string
    {
        return $this->review;
    }

    public function setReview(?string $review): self
    {
        $this->review = $review;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

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

    /**
     * @return Collection|Material[]
     */
    public function getMaterialHasCollectionPoint(): Collection
    {
        return $this->material_has_collectionPoint;
    }

    public function addMaterialHasCollectionPoint(Material $materialHasCollectionPoint): self
    {
        if (!$this->material_has_collectionPoint->contains($materialHasCollectionPoint)) {
            $this->material_has_collectionPoint[] = $materialHasCollectionPoint;
        }

        return $this;
    }

    public function removeMaterialHasCollectionPoint(Material $materialHasCollectionPoint): self
    {
        if ($this->material_has_collectionPoint->contains($materialHasCollectionPoint)) {
            $this->material_has_collectionPoint->removeElement($materialHasCollectionPoint);
        }

        return $this;
    }

    /**
     * @return Collection|objet[]
     */
    public function getObjetHasCollectionPoint(): Collection
    {
        return $this->objet_has_collectionPoint;
    }

    public function addObjetHasCollectionPoint(objet $objetHasCollectionPoint): self
    {
        if (!$this->objet_has_collectionPoint->contains($objetHasCollectionPoint)) {
            $this->objet_has_collectionPoint[] = $objetHasCollectionPoint;
        }

        return $this;
    }

    public function removeObjetHasCollectionPoint(objet $objetHasCollectionPoint): self
    {
        if ($this->objet_has_collectionPoint->contains($objetHasCollectionPoint)) {
            $this->objet_has_collectionPoint->removeElement($objetHasCollectionPoint);
        }

        return $this;
    }

    /**
     * @return Collection|category[]
     */
    public function getCategoryHasCollectionPoint(): Collection
    {
        return $this->category_has_collectionPoint;
    }

    public function addCategoryHasCollectionPoint(category $categoryHasCollectionPoint): self
    {
        if (!$this->category_has_collectionPoint->contains($categoryHasCollectionPoint)) {
            $this->category_has_collectionPoint[] = $categoryHasCollectionPoint;
        }

        return $this;
    }

    public function removeCategoryHasCollectionPoint(category $categoryHasCollectionPoint): self
    {
        if ($this->category_has_collectionPoint->contains($categoryHasCollectionPoint)) {
            $this->category_has_collectionPoint->removeElement($categoryHasCollectionPoint);
        }

        return $this;
    }
}
