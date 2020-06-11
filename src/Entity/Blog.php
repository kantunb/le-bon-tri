<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $short_content;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="blogs")
     */
    private $blog_has_tag;

    /**
     * @ORM\ManyToMany(targetEntity=Sources::class, inversedBy="blogs")
     */
    private $blog_has_sources;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTime());
        $this->blog_has_tag = new ArrayCollection();
        $this->blog_has_sources = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getShortContent(): ?string
    {
        return $this->short_content;
    }

    public function setShortContent(string $short_content): self
    {
        $this->short_content = $short_content;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|tag[]
     */
    public function getBlogHasTag(): Collection
    {
        return $this->blog_has_tag;
    }

    public function addBlogHasTag(tag $blogHasTag): self
    {
        if (!$this->blog_has_tag->contains($blogHasTag)) {
            $this->blog_has_tag[] = $blogHasTag;
        }

        return $this;
    }

    public function removeBlogHasTag(tag $blogHasTag): self
    {
        if ($this->blog_has_tag->contains($blogHasTag)) {
            $this->blog_has_tag->removeElement($blogHasTag);
        }

        return $this;
    }

    /**
     * @return Collection|sources[]
     */
    public function getBlogHasSources(): Collection
    {
        return $this->blog_has_sources;
    }

    public function addBlogHasSource(sources $blogHasSource): self
    {
        if (!$this->blog_has_sources->contains($blogHasSource)) {
            $this->blog_has_sources[] = $blogHasSource;
        }

        return $this;
    }

    public function removeBlogHasSource(sources $blogHasSource): self
    {
        if ($this->blog_has_sources->contains($blogHasSource)) {
            $this->blog_has_sources->removeElement($blogHasSource);
        }

        return $this;
    }
}
