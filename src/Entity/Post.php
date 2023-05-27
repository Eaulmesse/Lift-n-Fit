<?php

namespace App\Entity;

use App\Repository\PostRepository;
use App\Entity\PostReponse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'Post')]
    private ?User $user = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\OneToMany(mappedBy: 'post_id', targetEntity: PostReponse::class, cascade: array("remove"))]
    #[ORM\JoinColumn(name: 'post_id_id')]
    private Collection $postReponses;


    public function __construct()
    {
        $this->postReponses = new ArrayCollection();
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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, PostReponse>
     */
    public function getPostReponses(): Collection
    {
        return $this->postReponses;
    }

    public function addPostReponse(PostReponse $postReponse): self
    {
        if (!$this->postReponses->contains($postReponse)) {
            $this->postReponses->add($postReponse);
            $postReponse->setPostId($this);
        }

        return $this;
    }

    public function removePostReponse(PostReponse $postReponse): self
    {
        if ($this->postReponses->removeElement($postReponse)) {
            // set the owning side to null (unless already changed)
            if ($postReponse->getPostId() === $this) {
                $postReponse->setPostId(null);
            }
        }

        return $this;
    }
}
