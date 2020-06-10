<?php

namespace App\Entity;

use App\Repository\ObjetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ObjetRepository::class)
 */
class Objet
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
    private $avoidProduction;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="objets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Material_id;

    /**
     * @ORM\ManyToOne(targetEntity=category::class, inversedBy="objets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Use_id;

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

    public function getAvoidProduction(): ?string
    {
        return $this->avoidProduction;
    }

    public function setAvoidProduction(?string $avoidProduction): self
    {
        $this->avoidProduction = $avoidProduction;

        return $this;
    }

    public function getMaterialId(): ?Material
    {
        return $this->Material_id;
    }

    public function setMaterialId(?Material $Material_id): self
    {
        $this->Material_id = $Material_id;

        return $this;
    }

    public function getUseId(): ?category
    {
        return $this->Use_id;
    }

    public function setUseId(?category $Use_id): self
    {
        $this->Use_id = $Use_id;

        return $this;
    }
}
