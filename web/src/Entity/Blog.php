<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BlogRepository::class)]
class Blog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $descriptionB = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Please upload image")
     * @Assert\File(mimeTypes={"image/jpeg"})
     */
    private $imageB;

    #[ORM\ManyToOne]
    private ?User $idut = null;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="id", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getDescriptionB(): ?string
    {
        return $this->descriptionB;
    }

    public function setDescriptionB(string $descriptionB): self
    {
        $this->descriptionB = $descriptionB;

        return $this;
    }

    public function getImageB()
    {
        return $this->imageB;
    }

    public function setImageB($imageB)
    {
        $this->imageB = $imageB;

        return $this;
    }

    public function getIdut(): ?User
    {
        return $this->idut;
    }

    public function setIdut(?User $idut): self
    {
        $this->idut = $idut;

        return $this;
    }

    public function __toString()
    {
        return $this->getDescriptionB();
    }

    //test

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): ?Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setIdBlog($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getIdBlog() === $this) {
                $commentaire->setIdBlog(null);
            }
        }

        return $this;
    }


}
