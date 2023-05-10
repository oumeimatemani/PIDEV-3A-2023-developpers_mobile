<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use App\Repository\CommentaireRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateCM = null;

    #[ORM\Column(length: 255)]
    private ?string $texte = null;

    #[ORM\Column(length: 255)]
    private ?string $auteur = null;

    #[ORM\Column]
    private ?int $isactive = null;

    #[ORM\ManyToOne]
    private ?Blog $idBlog = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCM(): ?\DateTimeInterface
    {
        return $this->dateCM;
    }

    public function setDateCM(\DateTimeInterface $dateCM): self
    {
        $this->dateCM = $dateCM;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getIsactive(): ?int
    {
        return $this->isactive;
    }

    public function setIsactive(int $isactive): self
    {
        $this->isactive = $isactive;

        return $this;
    }

    public function getIdBlog(): ?Blog
    {
        return $this->idBlog;
    }

    public function setIdBlog(?Blog $idBlog): self
    {
        $this->idBlog = $idBlog;

        return $this;
    }

    public function __toString(){
        return (String) $this->getId();

    }


}
