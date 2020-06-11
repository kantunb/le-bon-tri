<?php

namespace App\Entity;

use App\Repository\CollectionPointTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity=CollectionPoint::class, mappedBy="collectionPointType")
     */
    private $collectionPoint_id;

    public function __construct()
    {
        $this->collectionPoint_id = new ArrayCollection();
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
}
