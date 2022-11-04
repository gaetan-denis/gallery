<?php

namespace App\Entity;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints AS Assert;
use App\Repository\PaintingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaintingRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[UniqueEntity(fields: ['titre'], message: 'Ce tableau existe déjà',)]
class Painting
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Votre titre doit contenir au moins {{limit}} caractères',
        maxMessage: 'Votre titre ne peut pas dépasser {{limit}} caractères',
    )]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(
        min:10,
        minMessage: 'Votre description doit contenir au moins {{limit}} caractères',
    )]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $creation = null;

    #[ORM\Column]
    #[Assert\Length(
        min:1,
        minMessage: 'Votre hauteur doit être au moins d\' {{limit}} caractères',
    )]
    private ?float $hauteur = null;


    #[ORM\Column]
    private ?float $largeur = null;
    #[Assert\Length(
        min:1,
        minMessage: 'Votre largeur doit être au moins d\' {{limit}} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'painting', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'paintings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Technical $technical = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreation(): ?int
    {
        return $this->creation;
    }

    public function setCreation(int $creation): self
    {
        $this->creation = $creation;

        return $this;
    }

    public function getHauteur(): ?float
    {
        return $this->hauteur;
    }

    public function setHauteur(float $hauteur): self
    {
        $this->hauteur = $hauteur;

        return $this;
    }

    public function getLargeur(): ?float
    {
        return $this->largeur;
    }

    public function setLargeur(float $largeur): self
    {
        $this->largeur = $largeur;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPainting($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPainting() === $this) {
                $comment->setPainting(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getTechnical(): ?Technical
    {
        return $this->technical;
    }

    public function setTechnical(?Technical $technical): self
    {
        $this->technical = $technical;

        return $this;
    }
}
