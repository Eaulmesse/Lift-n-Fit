<?php

namespace App\Entity;

use App\Repository\CoachRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoachRepository::class)]
class Coach
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column]
    private ?bool $diplome = null;

    #[ORM\OneToMany(mappedBy: 'coach_id', targetEntity: Conseil::class)]
    private Collection $conseil_id;

    public function __construct()
    {
        $this->conseil_id = new ArrayCollection();
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

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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

    public function isDiplome(): ?bool
    {
        return $this->diplome;
    }

    public function setDiplome(bool $diplome): self
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * @return Collection<int, Conseil>
     */
    public function getConseilId(): Collection
    {
        return $this->conseil_id;
    }

    public function addConseilId(Conseil $conseilId): self
    {
        if (!$this->conseil_id->contains($conseilId)) {
            $this->conseil_id->add($conseilId);
            $conseilId->setCoachId($this);
        }

        return $this;
    }

    public function removeConseilId(Conseil $conseilId): self
    {
        if ($this->conseil_id->removeElement($conseilId)) {
            // set the owning side to null (unless already changed)
            if ($conseilId->getCoachId() === $this) {
                $conseilId->setCoachId(null);
            }
        }

        return $this;
    }
}
