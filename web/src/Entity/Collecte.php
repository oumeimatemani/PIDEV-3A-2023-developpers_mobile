<?php

namespace App\Entity;

use App\Repository\CollecteRepository;
use Doctrine\ORM\Mapping as ORM;

use Doctrine\DBAL\Types\Types;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CollecteRepository::class)]
class Collecte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    
    private ?int $etatC = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length( min: 3, minMessage: 'type de véhicule doit avoir au minimum 3 caractaire',),]
    #[Assert\NotBlank(message: "vous devez mettre le type de votre vehicule !!!")]
    private ?string $typevehicule = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length( min: 8, minMessage: 'contact doit avoir au minimum 8 caractaire',),]
    #[Assert\NotBlank(message: "vous devez mettre votre contact !!!")]
    private ?string $contact = null;

    #[ORM\ManyToOne]
    #[Assert\NotBlank(message: "choisir user!!!")]
    private ?User $idusercollect = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Assert\NotBlank(message: "choisir don!!!")]
    private ?Don $iddon = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatC(): ?int
    {
        return $this->etatC;
    }

    public function setEtatC(int $etatC): self
    {
        $this->etatC = $etatC;

        return $this;
    }

    public function getTypevehicule(): ?string
    {
        return $this->typevehicule;
    }

    public function setTypevehicule(?string $typevehicule): self
    {
        $this->typevehicule = $typevehicule;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(?string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getIdusercollect(): ?User
    {
        return $this->idusercollect;
    }

    public function setIdusercollect(?User $idusercollect): self
    {
        $this->idusercollect = $idusercollect;
        // $this->idusercollect = 2 ;
        return $this;
    }


    public function getIddon(): ?Don
    {
        return $this->iddon;
    }

    public function setIddon(?Don $iddon): self
    {
        $this->iddon = $iddon;

        return $this;
    }
}
