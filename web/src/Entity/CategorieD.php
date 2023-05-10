<?php

namespace App\Entity;

use App\Repository\CategorieDRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieDRepository::class)]
class CategorieD
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]

    #[Assert\NotBlank(message: "vous devez mettre le description du nom !!!")]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]

    #[Assert\NotBlank(message: "vous devez mettre le description du description !!!")]
    private ?string $description = null;

    public function __toString()
    {
        return (string) $this->getId();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
