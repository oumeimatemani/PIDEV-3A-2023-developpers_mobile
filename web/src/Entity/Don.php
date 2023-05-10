<?php

namespace App\Entity;

use App\Repository\DonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DonRepository::class)]
class Don
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Length( min: 1, max: 3, minMessage: 'poids doit avoir au minimum 10 kgs', maxMessage: 'poids doit avoir au miximum 1000 kgs'),]
    #[Assert\NotBlank(message: "vous devez mettre le poids du don !!!")]
    private ?int $poids = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length( min: 5, minMessage: 'poids doit avoir au minimum 5 caractaire',),]
    #[Assert\NotBlank(message: "vous devez mettre le description du don !!!")]
    private ?string $descriptionD = null;

    #[ORM\Column]
    private ?int $etat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne]
    private ?User $iduserdon = null;

    #[ORM\ManyToOne]
    #[Assert\NotBlank(message: "choisir categorie!!!")]
    private ?CategorieD $idCategorie = null;






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(?int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getDescriptionD(): ?string
    {
        return $this->descriptionD;
    }

    public function setDescriptionD(?string $descriptionD): self
    {
        $this->descriptionD = $descriptionD;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

        return $this;
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

    public function getIduserdon(): ?User
    {
        return $this->iduserdon;
    }

    public function setIduserdon(?User $iduserdon): self
    {
        $this->iduserdon = $iduserdon;
        //$this->iduserdon = "2" ;
        return $this;
    }

    public function getIdCategorie(): ?CategorieD
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?CategorieD $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }
}
