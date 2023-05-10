<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateRV = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length( min: 10, minMessage: 'votre adresse doit avoir au minimum 10 caractaire',),]
    #[Assert\NotBlank(message: "choisir une adresse!!!")]
    private ?string $adresseRV = null;

    #[ORM\Column]
    private ?int $etatRV = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Collecte $idcollecte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRV(): ?\DateTimeInterface
    {
        return $this->dateRV;
    }

    public function setDateRV(?\DateTimeInterface $dateRV): self
    {
        $this->dateRV = $dateRV;

        return $this;
    }

    public function getAdresseRV(): ?string
    {
        return $this->adresseRV;
    }

    public function setAdresseRV(?string $adresseRV): self
    {
        $this->adresseRV = $adresseRV;

        return $this;
    }

    public function getEtatRV(): ?int
    {
        return $this->etatRV;
    }

    public function setEtatRV(int $etatRV): self
    {
        $this->etatRV = $etatRV;

        return $this;
    }

    public function getIdcollecte(): ?Collecte
    {
        return $this->idcollecte;
    }

    public function setIdcollecte(?Collecte $idcollecte): self
    {
        $this->idcollecte = $idcollecte;

        return $this;
    }
}
