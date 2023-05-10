<?php

namespace App\Entity;

use App\Repository\CategoriePRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoriePRepository::class)]
class CategorieP
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    /**
     *  @Groups({"post:read"})
     */
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"nom categorie doit etre non vide !")]
    #[Assert\Length( min : 5,minMessage :"Entrer un nom au min de 5 caracteres")]
    /**
     *  @Groups({"post:read"})
     */
    private ?string $nomC = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank(message:"description doit etre non vide !")]
    #[Assert\Length( min :10 ,minMessage :"Entrer une description au min de 10 caracteres")]
    /**
     *  @Groups({"post:read"})
     */
    private ?string $descriptionCat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    /**
     *  @Groups({"post:read"})
     */
    private ?\DateTimeInterface $dateCreation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomC(): ?string
    {
        return $this->nomC;
    }

    public function setNomC(string $nomC): self
    {
        $this->nomC = $nomC;

        return $this;
    }

    public function getDescriptionCat(): ?string
    {
        return $this->descriptionCat;
    }

    public function setDescriptionCat(?string $descriptionCat): self
    {
        $this->descriptionCat = $descriptionCat;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }
    public function __toString() {
        return $this->nomC;
    }
}
