<?php

namespace App\Entity;

use App\Repository\ConseilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConseilRepository::class)]
class Conseil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\ManyToOne(inversedBy: 'conseil_id')]
    private ?Coach $coach_id = null;

    #[ORM\ManyToMany(targetEntity: ConseilCategory::class, inversedBy: 'conseils')]
    private Collection $conseilcategory_id;

    public function __construct()
    {
        $this->conseilcategory_id = new ArrayCollection();
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

    public function getCoachId(): ?Coach
    {
        return $this->coach_id;
    }

    public function setCoachId(?Coach $coach_id): self
    {
        $this->coach_id = $coach_id;

        return $this;
    }

    /**
     * @return Collection<int, ConseilCategory>
     */
    public function getConseilcategoryId(): Collection
    {
        return $this->conseilcategory_id;
    }

    public function addConseilcategoryId(ConseilCategory $conseilcategoryId): self
    {
        if (!$this->conseilcategory_id->contains($conseilcategoryId)) {
            $this->conseilcategory_id->add($conseilcategoryId);
        }

        return $this;
    }

    public function removeConseilcategoryId(ConseilCategory $conseilcategoryId): self
    {
        $this->conseilcategory_id->removeElement($conseilcategoryId);

        return $this;
    }
}
