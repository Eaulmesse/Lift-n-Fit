<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Un compte utilise déjà cet email')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\Column]
    private ?bool $coach = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Post::class, cascade: array("remove"))]
    private Collection $Post;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Conseil::class, cascade: array("remove"))]
    private Collection $Conseil;

    #[ORM\Column(length: 255)]
    private ?string $pseudonyme = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PostReponse::class, cascade: array("remove"))]
    private Collection $post_reponse;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ImageName = null;

    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $content = null;

    public function __construct()
    {
        $this->Post = new ArrayCollection();
        $this->Conseil = new ArrayCollection();
        $this->post_reponse = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function isCoach(): ?bool
    {
        return $this->coach;
    }

    public function setCoach(bool $coach): self
    {
        $this->coach = $coach;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPost(): Collection
    {
        return $this->Post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->Post->contains($post)) {
            $this->Post->add($post);
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->Post->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Conseil>
     */
    public function getConseil(): Collection
    {
        return $this->Conseil;
    }

    public function addConseil(Conseil $conseil): self
    {
        if (!$this->Conseil->contains($conseil)) {
            $this->Conseil->add($conseil);
            $conseil->setUser($this);
        }

        return $this;
    }

    public function removeConseil(Conseil $conseil): self
    {
        if ($this->Conseil->removeElement($conseil)) {
            // set the owning side to null (unless already changed)
            if ($conseil->getUser() === $this) {
                $conseil->setUser(null);
            }
        }

        return $this;
    }

    public function getPseudonyme(): ?string
    {
        return $this->pseudonyme;
    }

    public function setPseudonyme(string $pseudonyme): self
    {
        $this->pseudonyme = $pseudonyme;

        return $this;
    }

    /**
     * @return Collection<int, PostReponse>
     */
    public function getPostReponse(): Collection
    {
        return $this->post_reponse;
    }

    public function addPostReponse(PostReponse $postReponse): self
    {
        if (!$this->post_reponse->contains($postReponse)) {
            $this->post_reponse->add($postReponse);
            $postReponse->setUser($this);
        }

        return $this;
    }

    public function removePostReponse(PostReponse $postReponse): self
    {
        if ($this->post_reponse->removeElement($postReponse)) {
            // set the owning side to null (unless already changed)
            if ($postReponse->getUser() === $this) {
                $postReponse->setUser(null);
            }
        }

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->ImageName;
    }

    public function setImageName(?string $ImageName): self
    {
        $this->ImageName = $ImageName;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->date = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function __serialize(): array
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        return [$this->id, $this->email, $this->password];
    }

    /**
     * @param array{int|null, string, string} $data
     */
    public function __unserialize(array $data): void
    {
        // add $this->salt too if you don't use Bcrypt or Argon2i
        [$this->id, $this->email, $this->password] = $data;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
